//  function checkPassword(str)
//  {
//    var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/;
//    return re.test(str);
//  }
var re = /^\w+$/;
function checkForm(form) {
  re = /^\w+$/;
  if(!re.test(form.user.value)) {
    alert("Error:  Username must contain only letters, numbers and underscores!");
    form.user.focus();
    return false;
  }
  re = /^\s*$/
  if (re.test(form.comment.value)) {
    alert("Error:  Textarea can not be empty!");
    form.comment.focus();
    //form.comment.reset();
    return false;
  }
  return true;
}

function pressed(e) {
  if ( (window.event ? event.keyCode : e.which) == 13) {
    e.preventDefault();
      document.getElementById('submit_button').click();
  }
}
