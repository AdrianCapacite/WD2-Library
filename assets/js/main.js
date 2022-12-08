console.info("Web Development 2 - Assignment 2022")
console.info("Author: Adrian Thomas Capacite C21348423")

/**
 * Enables all input fields in a form
 *
 * @param formID
 */
function enableEdit(formID) {
  let form = document.getElementById(formID);
  // Enable inputs for editing
  let inputs = form.getElementsByTagName("input");
  console.log(inputs)
  for (input of inputs) {
    input.disabled = false;
  }

  // Enable buttons for editing
  let buttonsToShow = form.getElementsByClassName("showOnEdit");
  for (button of buttonsToShow) {
    button.hidden = false;
  }

  // Hide buttons for editing
  let buttonsToHide = form.getElementsByClassName("hideOnEdit");
  for (button of buttonsToHide) {
    button.hidden = true;
  }
}