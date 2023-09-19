(function () {
  
})()

function enable(btn, target_id) {
  // get target 
  let target = document.querySelector(`#${target_id}`);
  // check button value
  !btn.checked ? target.setAttribute('disabled', 'disabled') : target.removeAttribute('disabled');
}

function create_div(classes_name = Array(), id = null) {
  // create div element
  let div = document.createElement('div');
  // check given classes
  if (classes_name.length > 0) {
    // loop on classes
    classes_name.forEach(class_name => {
      // assign every class to div 
      div.classList.add(class_name)
    });
  }
  // check id value
  if (id != null) {
    // assign id value to div
    div.setAttribute('id', id);
  }
  // return div
  return div;
}

