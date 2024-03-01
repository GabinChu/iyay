// Assuming you've included the "barcode.js" library

document.addEventListener('DOMContentLoaded', function () {
    // Generate barcode using barcode.js
    JsBarcode("#barcode", "123456789", {
        format: "CODE128",
        displayValue: false
    });
});
