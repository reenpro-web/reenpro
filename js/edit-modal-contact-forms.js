jQuery(window).on("load", function () {
  jQuery(document).ready(function () {
    
    // Prevent double submission
    jQuery(document).on("submit", ".wpcf7-form", function (e) {
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

    // Show custom error message when form is invalid
    document.addEventListener(
      "wpcf7invalid",
      function (event) {
        var $form = jQuery(event.target);
        // clear the submitting flag and re-enable submit
        $form.data("submitting", false);
        $form.find('button[type="submit"]').prop("disabled", false);

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
      },
      false
    );

    // Handle successful form submission
    document.addEventListener(
      "wpcf7mailsent",
      function (event) {
        var $formWrapper = null;
        var formId = null;

        // Determine which form was submitted
        if (jQuery(event.target).closest("#solarForm").length) {
          $formWrapper = jQuery("#solarForm");
          formId = "solarForm";
        } else if (jQuery(event.target).closest("#carForm").length) {
          $formWrapper = jQuery("#carForm");
          formId = "carForm";
        }

        // Only proceed if it's one of our target forms
        if ($formWrapper && $formWrapper.length) {
          // If a success message already exists, do nothing to prevent duplicates
          if ($formWrapper.find(".contact-form__success-message").length) {
            return;
          }

          // Remove any custom error messages
          $formWrapper.find(".custom-error").remove();

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
                $form.find('button[type="submit"]').prop("disabled", false);
              });
            }, 350);
          }, 20000);
        }
      },
      false
    );
  });
});

