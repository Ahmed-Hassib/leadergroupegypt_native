function link_validation(input, link, type) {
  // send a request to delete detail
  $.get(`../requests/index.php?do=link-validation&type=${type}&link=${link}`, (data) => {
    // check result
    if ($.parseJSON(data) == true) {
      valid_input(input);
    } else {
      invalid_input(input);
    }
  })
}