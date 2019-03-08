const Config = require('./config')
const clean = require('clean-text-utils')
const { send_to_ga } = require('./utils')

const HIDDEN_CLASS = 'd-none';

const cleanText = (str) => {
    if (!str) return ''
    str = clean.strip.newlines(str)
    str = clean.replace.smartChars(str)
    return clean.strip.extraSpace(str)
}

/**
 * Hide helper blocks
 */
const hideHelpers = () => {
    $('#helpBlock').addClass(HIDDEN_CLASS)
    $('#helpBlock2').addClass(HIDDEN_CLASS)
    $('#helpBlock3').addClass(HIDDEN_CLASS)
    $('#helpBlock4').addClass(HIDDEN_CLASS)
}

const handleSubmitButton = (e) => {
    e.preventDefault();
    const that = this;
    const parent = $(that).parent().parent();

    hideHelpers() // Hide helper blocks

    const orig_text = cleanText($('#create_shittalk_Text').val());
    if (!orig_text || orig_text.length < 2) {
        parent.addClass('has-error');
        $('#helpBlock4').removeClass(HIDDEN_CLASS);
        return;
    }
    const text = orig_text.toLowerCase();

    if (text.indexOf('http://') > -1 || text.indexOf('https://') > -1 || text.indexOf('www.') > -1 || text.indexOf('.com') > -1) {
        parent.addClass('has-error');
        $('#helpBlock2').removeClass(HIDDEN_CLASS);
        return;
    }

    if (text.indexOf('nigg') > -1 || text.indexOf('fag') > -1) {
        parent.addClass('has-error');
        $('#helpBlock3').removeClass(HIDDEN_CLASS);
        return;
    }
    const data = { submission: orig_text };
    checkDuplicate(data, parent)
}


const checkDuplicate = (pData, pParent) => {
    $.ajax({
        url: Config.endpoint + '/check-duplicate',
        contentType: "application/json; charset=utf-8",
        type: "POST",
        dataType: 'json',
        data: JSON.stringify(pData),
        success: function (sData) {
            if (sData.duplicate) {
                pParent.addClass('has-error');
                $('#helpBlock').removeClass(HIDDEN_CLASS);
            } else {
                submitRequest(pData)
            }
        },
        error: function (data) {
            console.error(data)
            pParent.addClass('has-error');
            $('#helpBlock').removeClass(HIDDEN_CLASS);
        }
    })
}

const submitRequest = (data) => {
    $.ajax({
        url: Config.endpoint,
        contentType: "application/json; charset=utf-8",
        type: "POST",
        dataType: 'json',
        data: JSON.stringify(data),
        success: function (data) {
            console.log(data)
            send_to_ga(`shittalk_submit`)
            if (!data.error) {
                location.reload();
            }
        },
        error: function (data) {
            console.error(data);
        }
    })
}

module.exports = handleSubmitButton;