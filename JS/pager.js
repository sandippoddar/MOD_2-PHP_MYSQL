// Storing HTML elements. 

const firstName = document.querySelector("#firstName");
const lastName = document.querySelector("#lastName");
let fullName = document.querySelector("#fullName");
let regex = /^[a-zA-Z]+$/;

/* Function for showing Error message while user enter any wrong input. */

function showError(Name,className) {
    if (Name === "") {
        document.querySelector('.' + className).textContent = "";
    }
    else if (!regex.test(Name)) {
        document.querySelector('.' + className).textContent = "Enter Only Alphabets";
    }
    else {
        document.querySelector('.' + className).textContent = "";
    }
}

firstName.addEventListener('input', () => {
    showError(firstName.value,'wrongFname');
});
lastName.addEventListener('input', () => {
    showError(lastName.value,'wrongLname');
});

/* Function for update the full_name field. */

function updateValue() {
    let regex1 = /[^a-zA-Z]/g;
    const firstName1 = firstName.value.replace(regex1, '');
    const lastName1 = lastName.value.replace(regex1, '');
    if (regex.test(firstName1)) {
        if (regex.test(lastName1)) {
            fullName.value = firstName1 + " " + lastName1;
        }
        else {
            fullName.value = firstName1 + " ";
        }
    }
    else {
        if (regex.test(lastName1)) {
            fullName.value = " " + lastName1;
        }
        else {
            fullName.value = "";
        }
    }
}
firstName.addEventListener('input', updateValue);
lastName.addEventListener('input', updateValue);
