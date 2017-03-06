//  function checkPassword(str)
//  {
//    var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/;
//    return re.test(str);
//  }
var re = /^\w+$/;
function checkForm(form) {
  if(!re.test(form.user.value)) {
    alert("Error:  Username must contain only letters, numbers and underscores!");
    form.user.focus();
    return false;
  }
  return true;
}

//function pressed(e, myform) {
//  if ( (window.event ? event.keyCode : e.which) == 13) {
//      document.forms["myform"].submit();
//  }
//}
