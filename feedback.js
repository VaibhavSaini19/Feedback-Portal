$(function() {
    $("#sortable").sortable();
    $("#sortable").disableSelection();
});

function checkOptLen() {}

function addOption(addOptBtn) {
    var parent = addOptBtn.target.parentElement;
    // console.log(parent);
    var newOption = document.querySelector(".option").cloneNode(true);
    newOption.nodeValue = "";
    newOption.getElementsByTagName("input")[0].value = "";
    var btn = addOptBtn.target;
    //console.log(btn);
    parent.insertBefore(newOption, btn);
}
function removeOpt(opt) {
    targetChild = opt.target.parentElement;
    // console.log(targetChild);
    var parent = targetChild.parentElement;
    // console.log(parent);
    parent.removeChild(targetChild);
}

function addSlot(slot) {
    var referenceChild = slot.target.parentElement.parentElement;
    var parent = referenceChild.parentElement;
    // console.log(referenceChild);
    // console.log(parent);
    var newSlot = document.querySelector(".slot").cloneNode(true);
    opts = newSlot.getElementsByClassName("options")[0];
    opts.innerHTML = `
    <div class="option">
        <i class="far fa-circle"></i>&nbsp;
        <input type="text" name="response" id="response" value="" placeholder="Option" />
        <div class="btn removeBtn" onclick="removeOpt(event)">
            <i class="fas fa-times"></i>
        </div>
    </div>
    <div class="btn btn-outline-info addOptBtn show" onclick="addOption(event)">
        <i class="fas fa-plus"></i>&nbsp; Add option
    </div>
    `;
    // console.log(opts);
    inputs = newSlot.getElementsByTagName("input");
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].value = "";
    }
    var temp = "customSwitch" + (document.getElementsByClassName("slot").length + 1);
    newSlot.getElementsByClassName("custom-control-input")[0].id = temp;
    newSlot.getElementsByClassName("custom-control-input")[0].checked = false;
    newSlot.getElementsByClassName("custom-control-label")[0].htmlFor = temp;
    referenceChild.parentNode.insertBefore(newSlot, referenceChild.nextSibling);
}
function removeSlot(slot) {
    targetChild = slot.target.parentElement.parentElement;
    // console.log(targetChild);
    var parent = targetChild.parentElement;
    // console.log(parent);
    parent.removeChild(targetChild);
}
function copySlot(slot) {
    var referenceChild = slot.target.parentElement.parentElement;
    var parent = referenceChild.parentElement;
    console.log(referenceChild);
    console.log(parent);
    var newSlot = document.querySelector(".slot").cloneNode(true);
    var temp = "customSwitch" + (document.getElementsByClassName("slot").length + 1);
    newSlot.getElementsByClassName("custom-control-input")[0].id = temp;
    newSlot.getElementsByClassName("custom-control-label")[0].htmlFor = temp;
    referenceChild.parentNode.insertBefore(newSlot, referenceChild.nextSibling);
}
