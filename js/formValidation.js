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