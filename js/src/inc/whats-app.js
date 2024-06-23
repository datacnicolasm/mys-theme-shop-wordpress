jQuery(document).ready(function ($) {

    const $whatsappIcon = $(".wht-icon");
    const $chatBox = $(".wht-chat-box");
    const $closeChat = $("#closeChat");

    $whatsappIcon.on("click", function() {
        $chatBox.toggleClass("active");
        console.log("Hola")
    });

    $closeChat.on("click", function() {
        $chatBox.removeClass("active");
    });
    
});
