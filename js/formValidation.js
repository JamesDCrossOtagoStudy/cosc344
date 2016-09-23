/**
 * Created by zw on 9/20/16.
 */
function isEmpty(value) {
    return typeof value == 'string' && !value.trim() || typeof value == 'undefined' || value === null;
}

function checkName(value) {
    if (value.length < 3) {
        return "Name must be at least 3 characters.\n"
    } else if (/[^a-zA-Z_-]/.test(value)) {
        return "Only a-z, A-Z, - and _ allowed in Name\n";
    }
    return "";
}

function checkMiddle_init(value) {
    if (!/[a-zA-z]/.test(value)) {
        return "It should be just one letter for middle_init\n";
    }
    return "";
}

function checkIRD(value) {
    if (value.length != 11) {
        return "Length of ird number should be 11\n";
    } else if (/[^0-9-]/.test(value)) {
        return "Only number and - are allowed in IRD\n";
    } else if (!/[0-9]{3}-[0-9]{3}-[0-9]{3}]/) {
        return "The format of IRD is ***-***-***\n";
    } else {
        return "";
    }
}

function checkContactNumber(value) {
    if (value.length != 10) {
        return "Cell phone number should have length 10\n";
    } else if (/[^0-9]/.test(value)) {
        return "Only 0-9 number is valid for cell phone\n";
    } else {
        return "";
    }
}

function checkCity(value) {
    if (value.length < 3) {
        return "City name must be at least 3 characters.\n"
    } else if (/[^a-zA-Z_-]/.test(value)) {
        return "Only a-z, A-Z, - and _ allowed in City\n";
    }
    return "";
}

function checkAddress(value) {
    if (value.length < 3) {
        return "Address name must be at least 3 characters.\n"
    } else if (/[^a-zA-Z0-9_ -]/.test(value)) {
        return "Only a-z, A-Z, 0-9, - and _ allowed in Address\n";
    }
    return "";
}

function checkAccountNumber(value) {
    if (!/[0-9]{4}-[0-9]]{4}-[0-9]{4}]/) {
        return "Account Number must be the format of ****-****-****.\n";
    } else {
        return "";
    }
}

function checkBookstoreID(value) {
    if(/[^0-9]/.test(value)) {
        return "Only digit 0-9 allowed.\n";
    } else if(value.length != 4) {
        return "The length of id is 4, such as 0001.\n";
    } else {
        return "";
    }
}