let img = document.getElementById('img');
let input = document.getElementById('poster');
const panel = document.getElementById("my-panel"); // Get the panel element
const closeBtn = document.getElementById("close-btn"); // Get the close button element
const refreshBtns = document.querySelectorAll(".refresh-btn");
const servicerefreshBtns = document.querySelectorAll(".servicerefresh-btn");


input.onchange = (e) => {
    if (input.files[0]) {
        img.src = URL.createObjectURL(input.files[0]);
    }
}

  closeBtn.addEventListener("click", function() { // Add event listener to the close button
    panel.style.display = "none"; // Hide the panel when the close button is clicked

  });
  refreshBtns.forEach(refreshBtn => { // Add event listeners to all elements with class "refresh-btn"
    refreshBtn.addEventListener("click", function() {
        window.location.href = "updatemovies.php"; // Refresh the page when the button is clicked
    });
});

servicerefreshBtns.forEach(refreshBtn => { // Add event listeners to all elements with class "refresh-btn"
  refreshBtn.addEventListener("click", function() {
      window.location.href = "services.php"; // Refresh the page when the button is clicked
  });
});



