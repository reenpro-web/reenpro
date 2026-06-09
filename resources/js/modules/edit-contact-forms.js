jQuery(window).on("load", function () {
  function unlockCf7Form(formEl) {
    var $form = jQuery(formEl);
    clearTimeout($form.data("submitUnlockTimer"));
    $form.data("submitting", false);
    $form.find('button[type="submit"]').prop("disabled", false);
  }

  function showCf7ErrorMessage(formEl, fallbackMessage) {
    var $form = jQuery(formEl);
    var message =
      (fallbackMessage) ||
      ($form.find(".wpcf7-response-output").text().trim()) ||
      "Bandant išsiųsti pranešimą įvyko klaida. Pabandykite dar kartą vėliau.";

    $form.find(".custom-error").remove();

    var $accept = $form.find(".contact-form__accept");
    if ($accept.length) {
      $accept.after('<div class="error-message custom-error">' + message + "</div>");
    } else {
      $form.find('button[type="submit"]').first().before(
        '<div class="error-message custom-error">' + message + "</div>"
      );
    }

    $form.find(".wpcf7-response-output").show();
  }

  function logCf7Submit(event) {
    var detail = event.detail || {};
    var payload = {
      status: detail.status,
      contactFormId: detail.contactFormId,
      message: detail.apiResponse && detail.apiResponse.message,
    };

    if (detail.status === "mail_sent") {
      console.info("[CF7]", payload);
      return;
    }

    console.warn("[CF7]", payload, detail.apiResponse || null);
  }

  function lockCf7Form(formEl) {
    var $form = jQuery(formEl);
    $form.data("submitting", true);

    // Defer disable so CF7 can start its submit/AJAX cycle first.
    setTimeout(function () {
      $form.find('button[type="submit"]').prop("disabled", true);
    }, 0);

    clearTimeout($form.data("submitUnlockTimer"));
    $form.data(
      "submitUnlockTimer",
      setTimeout(function () {
        if ($form.data("submitting")) {
          unlockCf7Form(formEl);
        }
      }, 30000)
    );
  }

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
  function validateSelect2Fields(formEl) {
    var $form = jQuery(formEl);

    config.forEach(function (item) {
      var $select = $form.find('select[name="' + item.selectName + '"]');
      if (!$select.length || !$select.is(":visible")) {
        return;
      }

      if (!$select.val()) {
        setTimeout(function () {
          markSelect2Invalid($select);
        }, shortTimeout);
      } else {
        clearSelect2Invalid($select);
      }
    });
  }

  document.addEventListener(
    "wpcf7invalid",
    function (event) {
		  var $form = jQuery(event.target);
		  unlockCf7Form(event.target);
      validateSelect2Fields(event.target);
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
    "wpcf7mailsent",
    function (event) {
      if (jQuery(event.target).closest("#offerModal").length) {
        return;
      }
      if (
        jQuery(event.target).is("#tab-personal .wpcf7-form") ||
        jQuery(event.target).is("#tab-business .wpcf7-form")
      ) {
        var $tabSubmittedForm = jQuery(event.target);
        var $tabScope = $tabSubmittedForm.closest(".contact-form");
        if (!$tabScope.length) {
          return;
        }
        var $tabHeading = $tabScope.find("h3.contact-form__heading").first();
        var $tabBlocks = $tabScope.find(".contact-tabs");
        var $tabHideTarget = $tabBlocks.length ? $tabBlocks : $tabSubmittedForm;
        var headingText = $tabHeading.text();

        // If a success message already exists, do nothing to prevent duplicates.
        if ($tabScope.find(".contact-form__success-message").length) {
          return;
        }

        // Remove any custom error messages.
        $tabScope.find(".custom-error").remove();
        // Fade out the form container (instead of removing it)
        $tabHideTarget.fadeOut(300, function () {

	      $tabHeading.text('Ačiū, kad užpildėte užklausą!');
          if (!$tabScope.find(".contact-form__success-message").length) {
            $tabHeading.after(
              '<div class="contact-form__success-message h6">Greitu metu su Jumis susisieksime ir atsakysime į visus rūpimus klausimus.</div>'
            );
          }
        });

        // After 20 seconds, fade out the success message and fade the form back in.
		setTimeout(function () {
		  $tabScope.find(".contact-form__success-message").fadeOut(300, function () {
			jQuery(this).remove();
			// Fade the form container back in
			$tabHideTarget.fadeIn(300, function() {
			  // once it's visible again, re-enable submit
			  var $form = jQuery(this).find("form.wpcf7-form").first();
			  $form.data("submitting", false);
			  $form.find('button[type="submit"]').prop("disabled", false);
			  $tabHeading.text(headingText);
			});
		  });
		}, 20000);

	  // AUTO FORM
      } else if (jQuery(event.target).is("#wpcf7-f374-o1 .wpcf7-form")) {
        var $autoScope = jQuery("#wpcf7-f374-o1");
        if ($autoScope.find(".contact-form__success-message").length) {
          return;
        }
        $autoScope.find(".custom-error").remove();

        jQuery("#wpcf7-f374-o1 .wpcf7-form").fadeOut(300, function () {
          // Insert the success message if it doesn't already exist.
          if (!$autoScope.find(".contact-form__success-message").length) {
			$autoScope.append(
              '<h3 class="mb-40 mb-lg-50 contact-form__thank-you">Ačiū, kad užpildėte užklausą!</h3>');
            $autoScope.append(
              '<div class="contact-form__success-message h6">Greitu metu su Jumis susisieksime ir atsakysime į visus rūpimus klausimus.</div>'
            );
          }
        });

        // After 20 seconds, fade out the success message and fade the form back in.
		setTimeout(function () {
		  $autoScope.find(".contact-form__thank-you, .contact-form__success-message").fadeOut(300, function () {
			jQuery(this).remove();
			// Fade the form container back in
			jQuery("#wpcf7-f374-o1 .wpcf7-form").fadeIn(300, function() {
			  var $form = jQuery(this);
			  $form.data("submitting", false);
			  $form.find('button[type="submit"]').prop("disabled", false);
			});
		  });
		}, 20000);

      } else {
        var $submittedForm = jQuery(event.target);
        if ($submittedForm.data("successHandled")) {
          return;
        }
        var $scope = $submittedForm.closest(".contact-form");
        if (!$scope.length) {
          $scope = $submittedForm.closest(".wpcf7");
        }
        if (!$scope.length) {
          return;
        }
        if ($scope.data("successShown")) {
          return;
        }
        if ($scope.find(".contact-form__success-message").length) {
          return;
        }
        $submittedForm.data("successHandled", true);
        $scope.data("successShown", true);

        $scope.find(".custom-error").remove();
        $scope.find(".contact-form__thank-you, .contact-form__success-message").remove();
        var $heading = $scope.find("h3.contact-form__heading").first();
        var $tabsContainer = $scope.find(".contact-tabs");
        var genericHeadingText = $heading.text();

        var hideTarget = $tabsContainer.length ? $tabsContainer : $submittedForm;
        hideTarget.fadeOut(300, function () {
          if ($heading.length) {
            $heading.text("Ačiū, kad užpildėte užklausą!");
            $heading.after(
              '<div class="contact-form__success-message h6">Greitu metu su Jumis susisieksime ir atsakysime į visus rūpimus klausimus.</div>'
            );
          } else {
            $scope.append('<h3 class="mb-40 mb-lg-50 contact-form__thank-you">Ačiū, kad užpildėte užklausą!</h3>');
            $scope.append(
              '<div class="contact-form__success-message h6">Greitu metu su Jumis susisieksime ir atsakysime į visus rūpimus klausimus.</div>'
            );
          }
        });

        setTimeout(function () {
          $scope.find(".contact-form__thank-you, .contact-form__success-message").fadeOut(300, function () {
            jQuery(this).remove();
          });

          setTimeout(function () {
            if ($heading.length) {
              $heading.text(genericHeadingText);
            }
            hideTarget.fadeIn(300, function () {
              $scope.find("form.wpcf7-form").each(function () {
                var $form = jQuery(this);
                $form.data("submitting", false);
                $form.data("successHandled", false);
                $form.find('button[type="submit"]').prop("disabled", false);
              });
              $scope.data("successShown", false);
            });
          }, 350);
        }, 20000);
      }
    },
    false
  );

  document.addEventListener(
    "wpcf7mailfailed",
    function (event) {
      unlockCf7Form(event.target);
      showCf7ErrorMessage(
        event.target,
        event.detail &&
          event.detail.apiResponse &&
          event.detail.apiResponse.message
      );
      logCf7Submit(event);
    },
    false
  );

  document.addEventListener(
    "wpcf7spam",
    function (event) {
      unlockCf7Form(event.target);
      showCf7ErrorMessage(
        event.target,
        (event.detail &&
          event.detail.apiResponse &&
          event.detail.apiResponse.message) ||
          "Užklausa buvo atmesta. Pabandykite dar kartą vėliau."
      );
      logCf7Submit(event);
    },
    false
  );

  // Always unlock after any CF7 submit lifecycle result.
  // This prevents stale disabled buttons on forms not handled
  // by the custom success branches below.
  document.addEventListener(
    "wpcf7submit",
    function (event) {
      unlockCf7Form(event.target);
      logCf7Submit(event);
    },
    false
  );

  // Dropdown logic
  var config = [
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
  config.forEach(function (item) {
    jQuery('[id^="' + item.idPrefix + '"] .select2-selection__placeholder').text(
      item.placeholderText
    );
    jQuery('[id^="' + item.idPrefix + '"]').css("transition", ".3s");
  });

  var shortTimeout = 420;

  function getSelect2RenderedEl($select) {
    var $rendered = $select
      .next(".select2")
      .find(".select2-selection__rendered")
      .first();
    return $rendered;
  }

  function markSelect2Invalid($select) {
    var $rendered = getSelect2RenderedEl($select);
    if ($rendered.length) {
      $rendered.css("border", "2px solid rgb(252, 57, 29)");
    }
  }

  function clearSelect2Invalid($select) {
    var $rendered = getSelect2RenderedEl($select);
    if ($rendered.length) {
      $rendered.css("border", "");
    }
  }

  // Remove red border as soon as user chooses a value.
  jQuery(document).on(
    "change",
    'select[name="privatus-sprendimas"], select[name="verslo-sprendimas"]',
    function () {
      var $select = jQuery(this);
      if ($select.val()) {
        clearSelect2Invalid($select);
      }
    }
  );

  // Helper function to set up a MutationObserver for a given id prefix.
  function setupObserver(idPrefix) {
    var $elements = jQuery('[id^="' + idPrefix + '"]');
    if ($elements.length) {
      $elements.each(function () {
        var targetNode = this;
        var observer = new MutationObserver(function (mutationsList) {
          mutationsList.forEach(function (mutation) {
            if (
              mutation.type === "attributes" &&
              mutation.attributeName === "title"
            ) {
              jQuery('[id^="' + idPrefix + '"]').css("border", "");
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
	
  // Lock via CF7 lifecycle only — never intercept native submit.
  document.addEventListener(
    "wpcf7submitting",
    function (event) {
      lockCf7Form(event.target);
      validateSelect2Fields(event.target);
    },
    false
  );

  // Set up MutationObservers for each type
  config.forEach(function (item) {
    setupObserver(item.idPrefix);
  });
});


