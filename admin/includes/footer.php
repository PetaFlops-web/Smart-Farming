  </div><!-- /content-area -->
</div><!-- /main-content -->

<script>
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('open');
  document.getElementById('sidebarOverlay').classList.toggle('show');
}
function closeSidebar() {
  document.getElementById('sidebar').classList.remove('open');
  document.getElementById('sidebarOverlay').classList.remove('show');
}
// Show menu btn on mobile
if (window.innerWidth <= 768) {
  document.getElementById('menuBtn').style.display = 'block';
}
window.addEventListener('resize', () => {
  document.getElementById('menuBtn').style.display = window.innerWidth <= 768 ? 'block' : 'none';
});
</script>
</body>
</html>
