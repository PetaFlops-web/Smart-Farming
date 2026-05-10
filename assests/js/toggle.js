function toggleFaq(el) {
  const isOpen = el.classList.contains("open");
  // Close all
  document
    .querySelectorAll(".faq-item")
    .forEach((item) => item.classList.remove("open"));
  // Open clicked if it was closed
  if (!isOpen) el.classList.add("open");
}
