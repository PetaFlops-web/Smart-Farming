    document.addEventListener("DOMContentLoaded", () => {
      const chatTrigger = document.getElementById("chatbot-trigger");
      const chatModal = document.getElementById("chatbot-modal");
      const chatClose = document.getElementById("chatbot-close");
      const chatIcon = chatTrigger.querySelector("i");

      function toggleChat() {
        const isOpen = chatModal.classList.contains("opacity-100");
        if (isOpen) {
          // Tutup modal
          chatModal.classList.remove(
            "opacity-100",
            "pointer-events-auto",
            "translate-y-0",
            "scale-100",
          );
          chatModal.classList.add(
            "opacity-0",
            "pointer-events-none",
            "translate-y-4",
            "scale-95",
          );

          // Kembalikan ikon ke chat
          chatIcon.classList.remove("fa-xmark");
          chatIcon.classList.add("fa-comment-dots");
        } else {
          // Buka modal
          chatModal.classList.remove(
            "opacity-0",
            "pointer-events-none",
            "translate-y-4",
            "scale-95",
          );
          chatModal.classList.add(
            "opacity-100",
            "pointer-events-auto",
            "translate-y-0",
            "scale-100",
          );

          // Ubah ikon trigger menjadi silang
          chatIcon.classList.remove("fa-comment-dots");
          chatIcon.classList.add("fa-xmark");
        }
      }

      chatTrigger.addEventListener("click", toggleChat);
      chatClose.addEventListener("click", toggleChat);
    });