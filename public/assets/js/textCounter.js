function textCounter(field,field2,maxlimit) {
    var countfield = document.getElementById(field2);
    console.log(countfield.value);
    if (field.value.length > maxlimit) {
        field.value = field.value.substring(0, maxlimit);
        return false;
    } else {
        countfield.innerHTML = maxlimit - field.value.length;
    }
}