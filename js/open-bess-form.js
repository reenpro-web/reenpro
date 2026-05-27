jQuery(function($) {
    // 1. Open Bess Form
    $("#displayBessForm").click(function() {
        $("#bessFormInModal").toggleClass("d-none");
        $("#formButtons").toggleClass("d-none");
    });

    // 2. Add Bess to the existing reset logic
    // This ensures if they click "Back", the Bess form hides and buttons reapppear
    $("#leaveToggle").click(function() {
        $("#bessFormInModal").addClass("d-none");
    });

    // 3. Ensure Bess is hidden when the modal is closed entirely
    $("#offerModal").on("hidden.bs.modal", function() {
        $("#bessFormInModal").addClass("d-none");
    });
});