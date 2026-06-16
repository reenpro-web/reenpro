jQuery(function () {
    function unlockCf7Form(formEl) {
      var $form = jQuery(formEl);
      clearTimeout($form.data("submitUnlockTimer"));
      $form.data("submitting", false);
      $form.find('button[type="submit"]').prop("disabled", false);
    }

    // Submit locking is handled globally in edit-contact-forms.js.
    document.addEventListener(
      "wpcf7invalid",
      function (event) {
        var $form = jQuery(event.target);
        unlockCf7Form(event.target);

        // Handle solarForm
        if (jQuery(event.target).closest("#solarForm").length) {
          if (
            !jQuery("#solarForm .contact-form__accept").next(
              ".error-message.custom-error"
            ).length
          ) {
            jQuery("#solarForm .contact-form__accept").after(
              '<div class="error-message custom-error">Užpildykite būtinuosius laukelius</div>'
            );
          }
        }
        // Handle carForm
        else if (jQuery(event.target).closest("#carForm").length) {
          if (
            !jQuery("#carForm .contact-form__accept").next(
              ".error-message.custom-error"
            ).length
          ) {
            jQuery("#carForm .contact-form__accept").after(
              '<div class="error-message custom-error">Užpildykite būtinuosius laukelius</div>'
            );
          }
        }

        // Fallback for all other CF7 forms on the site
        if (!$form.find(".error-message.custom-error").length) {
          var invalidMessage =
            (event.detail &&
              event.detail.apiResponse &&
              event.detail.apiResponse.message) ||
            "Užpildykite būtinuosius laukelius";
          var $accept = $form.find(".contact-form__accept");
          if ($accept.length) {
            $accept.after('<div class="error-message custom-error">' + invalidMessage + "</div>");
          } else {
            $form.find('button[type="submit"]').first().before(
              '<div class="error-message custom-error">' + invalidMessage + "</div>"
            );
          }
        }
      },
      false
    );

    document.addEventListener(
      "wpcf7mailfailed",
      function (event) {
        unlockCf7Form(event.target);
        jQuery(event.target).find(".custom-error").remove();
        jQuery(event.target).find(".wpcf7-response-output").show();
      },
      false
    );

    document.addEventListener(
      "wpcf7spam",
      function (event) {
        unlockCf7Form(event.target);
        jQuery(event.target).find(".custom-error").remove();
        jQuery(event.target).find(".wpcf7-response-output").show();
      },
      false
    );

    // Always unlock after any CF7 submit lifecycle result.
    // This prevents stale disabled buttons on forms not explicitly
    // covered by custom success handlers below.
    document.addEventListener(
      "wpcf7submit",
      function (event) {
        unlockCf7Form(event.target);
      },
      false
    );

    // Handle successful form submission
    document.addEventListener(
      "wpcf7mailsent",
      function (event) {
        var $formWrapper = null;
        var $submittedForm = jQuery(event.target);

        if ($submittedForm.data("modalSuccessHandled")) {
          return;
        }

        // Determine which form was submitted
        if (jQuery(event.target).closest("#solarForm").length) {
          $formWrapper = jQuery("#solarForm");
        } else if (jQuery(event.target).closest("#carForm").length) {
          $formWrapper = jQuery("#carForm");
        } else if (jQuery(event.target).closest("#bessFormInModal").length) {
          $formWrapper = jQuery("#bessFormInModal");
        }

        // Only proceed if it's one of our target forms
        if ($formWrapper && $formWrapper.length) {
          $submittedForm.data("modalSuccessHandled", true);
          // If a success message already exists, do nothing to prevent duplicates
          if ($formWrapper.find(".contact-form__success-message").length) {
            return;
          }

          // Remove any custom error messages
          $formWrapper.find(".custom-error").remove();
          $formWrapper.find(".contact-form__thank-you, .contact-form__success-message").remove();

          // Store the original content
          var $formContent = $formWrapper.find(".wpcf7-form");

          // Get heading and tabs to hide
          var $heading = $formWrapper.find(".contact-form__heading");
          var $tabs = $formWrapper.find(".contact-tabs");

          // Hide the heading and tabs
          $heading.fadeOut(300);
          $tabs.fadeOut(300);

          // Fade out the form
          $formContent.fadeOut(300, function () {
            // Insert the success message if it doesn't already exist
            if (!$formWrapper.find(".contact-form__success-message").length) {
              $formWrapper.append(
                '<h3 class="mb-40 mb-lg-50 contact-form__thank-you">Ačiū, kad užpildėte užklausą!</h3>'
              );
              $formWrapper.append(
                '<div class="contact-form__success-message h6">Greitu metu su Jumis susisieksime ir atsakysime į visus rūpimus klausimus.</div>'
              );
            }
          });

          // After 20 seconds, fade out the success message and fade the form back in
          setTimeout(function () {
            $formWrapper
              .find(".contact-form__thank-you, .contact-form__success-message")
              .fadeOut(300, function () {
                jQuery(this).remove();
              });

            // Wait for fade out to complete, then fade form back in
            setTimeout(function () {
              // Show heading and tabs again
              $heading.fadeIn(300);
              $tabs.fadeIn(300);

              $formWrapper.find(".wpcf7-form").fadeIn(300, function () {
                var $form = jQuery(this);
                $form.data("submitting", false);
                $form.data("modalSuccessHandled", false);
                $form.find('button[type="submit"]').prop("disabled", false);
              });
            }, 350);
          }, 20000);
        }
      },
      false
    );
});
