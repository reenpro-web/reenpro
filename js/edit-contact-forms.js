jQuery(window).on("load", function () {
	jQuery(document).ready(function() {
	  // Check if the URL contains "client=business"
	  if (window.location.href.indexOf('client=business') > -1) {
		// Show the business client tab
		jQuery('#heading-business').tab('show');

		// Wait a short moment to ensure the tab content is rendered
		setTimeout(function() {
		  // Scroll to the form container
		  jQuery('html, body').animate({
			scrollTop: jQuery("#mainForm").offset().top
		  }, 0); // Duration: 1000ms
		}, 10); // Adjust the delay as needed
	  }
	});

  // Show custom error message when form is invalid
  document.addEventListener(
    "wpcf7invalid",
    function (event) {
		  var $form = jQuery(event.target);
  // clear the submitting flag and re-enable submit
  $form.data("submitting", false);
  $form.find('button[type="submit"]').prop("disabled", false);
      if (jQuery(event.target).is("#tab-personal .wpcf7-form")) {
        if (
          !jQuery("#tab-personal .contact-form__accept").next(
            ".error-message.custom-error"
          ).length
        ) {
          jQuery("#tab-personal .contact-form__accept").after(
            '<div class="error-message custom-error">Užpildykite būtinuosius laukelius</div>'
          );
        }
      } else if (jQuery(event.target).is("#tab-business .wpcf7-form")) {
        if (
          !jQuery("#tab-business .contact-form__accept").next(
            ".error-message.custom-error"
          ).length
        ) {
          jQuery("#tab-business .contact-form__accept").after(
            '<div class="error-message custom-error">Užpildykite būtinuosius laukelius</div>'
          );
        }
      } else if (jQuery(event.target).is("#wpcf7-f374-o1 .wpcf7-form")) {
        if (
          !jQuery("#wpcf7-f374-o1 .contact-form__accept").next(
            ".error-message.custom-error"
          ).length
        ) {
          jQuery("#wpcf7-f374-o1 .contact-form__accept").after(
            '<div class="error-message custom-error">Užpildykite būtinuosius laukelius</div>'
          );
        }
      }
    },
    false
  );

  document.addEventListener(
    "wpcf7mailsent",
    function (event) {
      if (
        jQuery(event.target).is("#tab-personal .wpcf7-form") ||
        jQuery(event.target).is("#tab-business .wpcf7-form")
      ) {
        // If a success message already exists, do nothing to prevent duplicates.
        if (jQuery(".contact-form__success-message").length) {
          return;
        }

        // Remove any custom error messages.
        jQuery(".custom-error").remove();
        var headingText = jQuery('h3.contact-form__heading').first().text();
        // Fade out the form container (instead of removing it)
        jQuery(".contact-tabs").fadeOut(300, function () {

	      jQuery('h3.contact-form__heading').text('Ačiū, kad užpildėte užklausą!');
          if (!jQuery(".contact-form__success-message").length) {
            jQuery(".contact-form__heading").after(
              '<div class="contact-form__success-message h6">Greitu metu su Jumis susisieksime ir atsakysime į visus rūpimus klausimus.</div>'
            );
          }
        });

        // After 20 seconds, fade out the success message and fade the form back in.
		setTimeout(function () {
		  jQuery(".contact-form__success-message").fadeOut(300, function () {
			jQuery(this).remove();
			// Fade the form container back in
			jQuery(".contact-tabs").fadeIn(300, function() {
			  // once it's visible again, re-enable submit
			  var $form = jQuery(this).find("form.wpcf7-form");
			  $form.data("submitting", false);
			  $form.find('button[type="submit"]').prop("disabled", false);
			  jQuery('h3.contact-form__heading').text(headingText);
			});
		  });
		}, 20000);

	  // AUTO FORM
      } else if (jQuery(event.target).is("#wpcf7-f374-o1 .wpcf7-form")) {
        if (jQuery(".contact-form__success-message").length) {
          return;
        }
        jQuery(".custom-error").remove();

        jQuery("#wpcf7-f374-o1 .wpcf7-form").fadeOut(300, function () {
          // Insert the success message if it doesn't already exist.
          if (!jQuery(".contact-form__success-message").length) {
			jQuery("#wpcf7-f374-o1").append(
              '<h3 class="mb-40 mb-lg-50 contact-form__thank-you">Ačiū, kad užpildėte užklausą!</h3>');
            jQuery("#wpcf7-f374-o1").append(
              '<div class="contact-form__success-message h6">Greitu metu su Jumis susisieksime ir atsakysime į visus rūpimus klausimus.</div>'
            );
          }
        });

        // After 20 seconds, fade out the success message and fade the form back in.
		setTimeout(function () {
		  jQuery(".contact-form__thank-you, .contact-form__success-message").fadeOut(300, function () {
			jQuery(this).remove();
			// Fade the form container back in
			jQuery("#wpcf7-f374-o1 .wpcf7-form").fadeIn(300, function() {
			  var $form = jQuery(this);
			  $form.data("submitting", false);
			  $form.find('button[type="submit"]').prop("disabled", false);
			});
		  });
		}, 20000);

      }
    },
    false
  );

  // Dropdown logic
  const config = [
    {
      type: "privatus",
      placeholderText: "Pasirinkite stogo dangą*",
      selectName: "privatus-sprendimas",
      idPrefix: "select2-privatus-sprendimas",
    },
    {
      type: "verslo",
      placeholderText: "Pasirinkite sprendimą*",
      selectName: "verslo-sprendimas",
      idPrefix: "select2-verslo-sprendimas",
    },
  ];

  // Update dropdown placeholder text and add a smooth transition
  config.forEach((item) => {
    jQuery(`[id^="${item.idPrefix}"] .select2-selection__placeholder`).text(
      item.placeholderText
    );
    jQuery(`[id^="${item.idPrefix}"]`).css("transition", ".3s");
  });

  const shortTimeout = 420;

  // Validation on form submit: if the active select is empty, add a red border after a delay.
  jQuery(document).on("submit", ".wpcf7-form", function () {
    // Determine which type is active (assuming #heading-personal is active for "privatus")
    const activeType = jQuery("#heading-personal").hasClass("active")
      ? "privatus"
      : "verslo";
    const currentConfig = config.find((c) => c.type === activeType);
    if (!currentConfig) return;

    const $select = jQuery(`select[name="${currentConfig.selectName}"]`);
    if (!$select.val()) {
      setTimeout(() => {
        jQuery(`[id^="${currentConfig.idPrefix}"]`).css(
          "border",
          "2px solid rgb(252, 57, 29)"
        );
      }, shortTimeout);
    }
  });

  // Helper function to set up a MutationObserver for a given id prefix.
  function setupObserver(idPrefix) {
    const $elements = jQuery(`[id^="${idPrefix}"]`);
    if ($elements.length) {
      $elements.each(function () {
        const targetNode = this;
        const observer = new MutationObserver((mutationsList) => {
          mutationsList.forEach((mutation) => {
            if (
              mutation.type === "attributes" &&
              mutation.attributeName === "title"
            ) {
              jQuery(`[id^="${idPrefix}"]`).css("border", "");
            }
          });
        });
        observer.observe(targetNode, {
          attributes: true,
          attributeFilter: ["title"],
        });
      });
    }
  }
	
	jQuery(document).on("submit", ".wpcf7-form", function(e) {
  var $form = jQuery(this);

  // if we've already started submitting, block it
  if ($form.data("submitting")) {
    e.preventDefault();
    return false;
  }

  // mark it and disable the button
  $form.data("submitting", true);
  $form.find('button[type="submit"]').prop("disabled", true);
});

  // Set up MutationObservers for each type
  config.forEach((item) => {
    setupObserver(item.idPrefix);
  });
});


