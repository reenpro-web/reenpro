/**
 * CF7 helpers: stuck-form recovery and visible validation errors.
 */
(function () {
  function showCf7FormError(formEl, message) {
    var $form = window.jQuery ? window.jQuery(formEl) : null;
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

  function unlockCf7Form(formEl) {
    var $form = window.jQuery ? window.jQuery(formEl) : null;
    if (!$form || !$form.length) {
      return;
    }

    $form.removeClass("submitting sending validating resettings");
    $form.attr("data-status", "init");
    if (formEl.wpcf7) {
      formEl.wpcf7.status = "init";
    }
    $form.data("submitting", false);
    $form.find('button[type="submit"], input[type="submit"]').prop("disabled", false);
    $form.find(".wpcf7-spinner").css("visibility", "");
  }

  function attachLifecycleHandlers() {
    [
      "wpcf7invalid",
      "wpcf7unaccepted",
      "wpcf7spam",
      "wpcf7mailfailed",
      "wpcf7mailsent",
      "wpcf7statuschanged",
      "wpcf7submit",
    ].forEach(function (eventName) {
      document.addEventListener(
        eventName,
        function (event) {
          if (
            eventName === "wpcf7mailfailed" ||
            eventName === "wpcf7invalid" ||
            eventName === "wpcf7unaccepted" ||
            eventName === "wpcf7spam"
          ) {
            unlockCf7Form(event.target);
          }
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

  function attachSubmitRecovery() {
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

        var status = form.getAttribute("data-status");

        // Recover forms left in "submitting" after a failed/slow request.
        if (status === "submitting" || status === "validating") {
          unlockCf7Form(form);
        }
      },
      true
    );
  }

  function init() {
    attachLifecycleHandlers();
    attachUnacceptedHandler();
    attachSubmitRecovery();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
