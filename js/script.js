document.querySelectorAll("#barangForm input").forEach((el, index, arr) => {
  el.addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
      e.preventDefault();
      const next = arr[index + 1];
      if (next) next.focus();
    }
  });
});
