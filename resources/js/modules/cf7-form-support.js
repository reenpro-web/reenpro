/**
 * CF7 helpers: visible errors, console diagnostics, reCAPTCHA stall detection.
 * Runs immediately — must not wait for window.load.
 */
(function () {
  function showCf7FormError(formEl, message) {
    var form = formEl;
    if (!form || !form.closest) {
      return;
    }

    var $form = window.jQuery ? window.jQuery(form) : null;
    if (!$form || !$form.length) {
      return;
    }

    $form.find(".custom-error").remove();

    var $accept = $form.find(".contact-form__accept");
    if ($accept.length) {
      $accept.after('<div class="error-message custom-error">' + message + "</div>");
    } else {
      $form.find('button[type="submit"], input[type="submit"]').first().before(
        '<div class="error-message custom-error">' + message + "</div>"
      );
    }

    $form.find(".wpcf7-response-output").show();
  }

  function logCf7(eventName, detail) {
    if (detail && detail.status === "mail_sent") {
      console.info("[CF7]", eventName, detail);
      return;
    }
    console.warn("[CF7]", eventName, detail || null);
  }

  function attachLifecycleLogging() {
    [
      "wpcf7invalid",
      "wpcf7unaccepted",
      "wpcf7spam",
      "wpcf7mailfailed",
      "wpcf7mailsent",
      "wpcf7submitting",
      "wpcf7submit",
    ].forEach(function (eventName) {
      document.addEventListener(
        eventName,
        function (event) {
          logCf7(eventName, event.detail || null);
        },
        false
      );
    });
  }

  function attachUnacceptedHandler() {
    document.addEventListener(
      "wpcf7unaccepted",
      function (event) {
        showCf7FormError(
          event.target,
          (event.detail &&
            event.detail.apiResponse &&
            event.detail.apiResponse.message) ||
            "Pažymėkite privatumo politikos sutikimą."
        );
      },
      false
    );
  }

  function attachSubmitDiagnostics() {
    document.addEventListener(
      "click",
      function (event) {
        var button = event.target.closest(".wpcf7-submit");
        if (!button || button.disabled) {
          return;
        }

        var form = button.closest("form.wpcf7-form");
        if (!form) {
          return;
        }

        console.info("[CF7] Submit button clicked", {
          formId: form.closest(".wpcf7") && form.closest(".wpcf7").id,
          status: form.getAttribute("data-status"),
          grecaptcha: typeof window.grecaptcha,
        });

        var progressed = false;
        var settled = false;

        function onSubmitting() {
          progressed = true;
        }

        function onSubmit() {
          settled = true;
        }

        form.addEventListener("wpcf7submitting", onSubmitting, { once: true });
        form.addEventListener("wpcf7submit", onSubmit, { once: true });

        window.setTimeout(function () {
          form.removeEventListener("wpcf7submitting", onSubmitting);
          form.removeEventListener("wpcf7submit", onSubmit);

          if (settled || progressed) {
            return;
          }

          var message =
            typeof window.grecaptcha === "undefined"
              ? "Saugos patikra (reCAPTCHA) neįkelta. Priimkite slapukus ir perkraukite puslapį."
              : "Formos nepavyko išsiųsti. Priimkite slapukus, išjunkite reklamos blokavimą ir bandykite dar kartą.";

          showCf7FormError(form, message);
          console.warn("[CF7] Submit stalled — likely reCAPTCHA blocked", {
            grecaptcha: typeof window.grecaptcha,
            wpcf7: typeof window.wpcf7,
          });
        }, 4000);
      },
      true
    );

    document.addEventListener(
      "submit",
      function (event) {
        if (event.target && event.target.matches("form.wpcf7-form")) {
          console.info("[CF7] Native submit event fired", {
            status: event.target.getAttribute("data-status"),
          });
        }
      },
      true
    );
  }

  function init() {
    attachLifecycleLogging();
    attachUnacceptedHandler();
    attachSubmitDiagnostics();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
