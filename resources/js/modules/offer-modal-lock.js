jQuery(function ($) {
  var isLocked = false;
  var statePollTimer = null;

  function isOfferModalOpen() {
    var modalEl = document.getElementById("offerModal");
    if (!modalEl) {
      return false;
    }
    var modalHasShowClass = modalEl.classList.contains("show");
    var bodyHasModalOpen = document.body.classList.contains("modal-open");
    return modalHasShowClass || bodyHasModalOpen;
  }

  function lockOfferModalPage() {
    if (isLocked) {
      return;
    }
    isLocked = true;

    var scrollTop = window.pageYOffset || document.documentElement.scrollTop || 0;
    $("body").data("offerModalScrollTop", scrollTop);

    document.documentElement.classList.add("offer-modal-open");
    document.body.classList.add("offer-modal-open");

    document.documentElement.style.setProperty("overflow", "hidden", "important");
    document.body.style.setProperty("overflow", "hidden", "important");
    document.body.style.setProperty("position", "fixed", "important");
    document.body.style.setProperty("top", "-" + scrollTop + "px", "important");
    document.body.style.setProperty("left", "0", "important");
    document.body.style.setProperty("right", "0", "important");
    document.body.style.setProperty("width", "100%", "important");
  }

  function unlockOfferModalPage() {
    if (!isLocked) {
      return;
    }
    isLocked = false;

    var scrollTop = parseInt($("body").data("offerModalScrollTop"), 10) || 0;

    document.documentElement.classList.remove("offer-modal-open");
    document.body.classList.remove("offer-modal-open");

    document.documentElement.style.removeProperty("overflow");
    document.body.style.removeProperty("overflow");
    document.body.style.removeProperty("position");
    document.body.style.removeProperty("top");
    document.body.style.removeProperty("left");
    document.body.style.removeProperty("right");
    document.body.style.removeProperty("width");

    window.scrollTo(0, scrollTop);
  }

  function syncOfferModalLock() {
    if (isOfferModalOpen()) {
      lockOfferModalPage();
    } else {
      unlockOfferModalPage();
    }
  }

  $(document).on("show.bs.modal shown.bs.modal", "#offerModal", lockOfferModalPage);
  $(document).on("hide.bs.modal hidden.bs.modal", "#offerModal", unlockOfferModalPage);

  // Fallback: some modal flows skip events or fire out of order.
  // Keep state in sync with body/modal classes.
  if ("MutationObserver" in window) {
    var observer = new MutationObserver(syncOfferModalLock);
    observer.observe(document.body, {
      attributes: true,
      attributeFilter: ["class"]
    });
    var modalNode = document.getElementById("offerModal");
    if (modalNode) {
      observer.observe(modalNode, {
        attributes: true,
        attributeFilter: ["class", "style"]
      });
    }
  }

  statePollTimer = window.setInterval(syncOfferModalLock, 120);

  // initial sync
  syncOfferModalLock();
});
