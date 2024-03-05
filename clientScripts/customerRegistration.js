var $ = function(id) {
    return document.getElementById(id);
};

function validatePassword() {
    //DEBUG alert("In validateProductData function");
    var password = $("password").value;
    var verified_password = $("verified_password").value;
    
    if (password != verified_password) {
        alert("Passwords must match.");

        password = "";
        verified_password = "";
        password.focus();

        return false;
    } 
    else { 
        return true;
    }
}//validatePassword