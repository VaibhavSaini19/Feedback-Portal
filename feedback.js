$(function() {
    $("#sortable").sortable();
    $("#sortable").disableSelection();
});

function checkOptLen(slotElement) {
    // console.log(slotElement);
    optsLen = slotElement.getElementsByClassName("option").length;
    return optsLen;
}

function addOption(addOptBtn) {
    var slotElement = addOptBtn.target.parentElement.parentElement;
    var optsLen = checkOptLen(slotElement);
    // console.log(optsLen);
    if (optsLen <= 4) {
        $(slotElement.getElementsByClassName("addOptBtn")).show();
        var parent = addOptBtn.target.parentElement;
        // console.log(parent);
        var newOption = slotElement.querySelector(".option").cloneNode(true);
        newOption.nodeValue = "";
        newOption.getElementsByTagName("input")[0].value = "";
        console.log(newOption.getElementsByTagName("input")[0].name);
        var btn = addOptBtn.target;
        //console.log(btn);
        parent.insertBefore(newOption, btn);
    }
    if (optsLen >= 4) {
        $(slotElement.getElementsByClassName("addOptBtn")).hide();
    }
    $(slotElement.getElementsByClassName("removeBtn")).show();
    // var optsLen = checkOptLen(slotElement)
    // console.log(optsLen);
}
function removeOpt(opt) {
    var slotElement = opt.target.parentElement.parentElement.parentElement;
    var optsLen = checkOptLen(slotElement);
    // console.log(opt);
    if (optsLen >= 2) {
        $(slotElement.getElementsByClassName("removeBtn")).show();
        targetChild = opt.target.parentElement;
        // console.log(targetChild);
        var parent = targetChild.parentElement;
        // console.log(parent);
        parent.removeChild(targetChild);
    }
    if (optsLen <= 2) {
        $(slotElement.getElementsByClassName("removeBtn")).hide();
    }
    $(slotElement.getElementsByClassName("addOptBtn")).show();
}

function getSlotsLen() {
    return document.getElementsByClassName("slot").length;
}

function addSlot(slot) {
    var referenceChild = slot.target.parentElement.parentElement;
    var parent = referenceChild.parentElement;
    // console.log(referenceChild);
    // console.log(parent);
    var totalSlots = getSlotsLen() + 1;
    var newSlot = document.querySelector(".slot").cloneNode(true);
    var qn = newSlot.getElementsByClassName("question")[0];
    qn.innerHTML =
        `
    <input type="text" name="question` +
        totalSlots +
        `" id="question" placeholder="Question" />
    `;
    var opts = newSlot.getElementsByClassName("options")[0];
    opts.innerHTML =
        `
    <div class="option">
        <i class="far fa-circle"></i>&nbsp;
        <input type="text" name="response` +
        totalSlots +
        `[]" id="response" value="" placeholder="Option" />
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
    // console.log(referenceChild);
    // console.log(parent);
    // var newSlot = document.querySelector(".slot").cloneNode(true);
    var newSlot = referenceChild.cloneNode(true);
    // console.log(newSlot);
    var temp = "customSwitch" + (document.getElementsByClassName("slot").length + 1);
    newSlot.getElementsByClassName("custom-control-input")[0].id = temp;
    newSlot.getElementsByClassName("custom-control-label")[0].htmlFor = temp;
    var totalSlots = getSlotsLen() + 1;
    // console.log(totalSlots);
    newSlot.querySelector('#question').name = 'question' + (totalSlots);
    // console.log(newSlot.querySelector('#question').name);
    newSlot.querySelectorAll('.response').forEach(element => {
        element.name = 'response' + (totalSlots) + '[]';
    });
    // console.log(newSlot.querySelectorAll('.response')[0].name);
    referenceChild.parentNode.insertBefore(newSlot, referenceChild.nextSibling);
}
