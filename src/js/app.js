

$(window).on("load", () => {
  setTimeout(() => {
    $("#preloader").addClass("animate__animated animate__fadeOut preloader-hidden");
    setTimeout(() => $("#preloader").hide(), 200);
  }, 1000);
});

