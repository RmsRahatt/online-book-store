function validateLogin(){

    var email =
    document.getElementById(
        "loginEmail"
    ).value.trim();

    var password =
    document.getElementById(
        "loginPassword"
    ).value;

    var errorBox =
    document.getElementById(
        "loginError"
    );

    if(email == "" || password == ""){

        errorBox.innerHTML =
        "All Fields Required";

        return false;
    }

    errorBox.innerHTML = "";
    return true;
}

function validateSignup(){

    var name =
    document.getElementById(
        "signupName"
    ).value.trim();

    var email =
    document.getElementById(
        "signupEmail"
    ).value.trim();

    var password =
    document.getElementById(
        "signupPassword"
    ).value;

    var role =
    document.getElementById(
        "signupRole"
    ).value;

    var address =
    document.getElementById(
        "signupAddress"
    ).value.trim();

    var phone =
    document.getElementById(
        "signupPhone"
    ).value.trim();

    var errorBox =
    document.getElementById(
        "signupError"
    );

    if(
        name == "" ||
        email == "" ||
        password == "" ||
        role == "" ||
        address == "" ||
        phone == ""
    ){

        errorBox.innerHTML =
        "All Fields Required";

        return false;
    }

    if(password.length < 8){

        errorBox.innerHTML =
        "Password Must Be 8 Characters";

        return false;
    }

    errorBox.innerHTML = "";
    return true;
}

function validateProfile(){

    var name =
    document.getElementById(
        "profileName"
    ).value.trim();

    var email =
    document.getElementById(
        "profileEmail"
    ).value.trim();

    var address =
    document.getElementById(
        "profileAddress"
    ).value.trim();

    var phone =
    document.getElementById(
        "profilePhone"
    ).value.trim();

    var errorBox =
    document.getElementById(
        "profileError"
    );

    if(
        name == "" ||
        email == "" ||
        address == "" ||
        phone == ""
    ){

        errorBox.innerHTML =
        "All Fields Required";

        return false;
    }

    errorBox.innerHTML = "";
    return true;
}