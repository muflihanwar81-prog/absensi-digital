<div id="idle-modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); align-items:center; justify-content:center; z-index:1000;">
  <div style="background:
    <h2 style="margin:0 0 1rem; font-size:1.5rem; color:
    <p style="margin:0 0 1.5rem; color:
    <form id="logout-form" method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" style="padding:0.6rem 1.2rem; background:
        Login Again
      </button>
    </form>
  </div>
</div>

<script>
(function() {
  const idleTimeout = 15 * 60 * 1000; 
  let timeoutHandle;

  function showTimeoutModal() {
    const modal = document.getElementById('idle-modal');
    if (modal) {
      modal.style.display = 'flex';
    }
  }

  function resetTimer() {
    clearTimeout(timeoutHandle);
    timeoutHandle = setTimeout(showTimeoutModal, idleTimeout);
  }

  
  ['mousemove', 'mousedown', 'keypress', 'touchstart', 'scroll'].forEach(event => {
    document.addEventListener(event, resetTimer);
  });

  
  resetTimer();
})();
</script>

