const Config = require('./config')

const handleSubmitButton = (e) => {
    e.preventDefault();
    const that = this;
    const parent = $(that).parent().parent();

    const orig_text = $('#create_shittalk_Text').val();
    if (!orig_text || orig_text.length < 2) {
        parent.addClass('has-error');
        $('#helpBlock4').removeClass('hidden');
        return;
    }
    const text = orig_text.toLowerCase();

    if (text.indexOf('http://') > -1 || text.indexOf('https://') > -1 || text.indexOf('www.') > -1 || text.indexOf('.com') > -1) {
        parent.addClass('has-error');
        $('#helpBlock2').removeClass('hidden');
        return;
    }

    if (text.indexOf('nigg') > -1 || text.indexOf('fag') > -1) {
        parent.addClass('has-error');
        $('#helpBlock3').removeClass('hidden');
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
                $('#helpBlock').removeClass('hidden');
            } else {
                submitRequest(pData)
            }
        },
        error: function (data) {
            console.error(data)
            pParent.addClass('has-error');
            $('#helpBlock').removeClass('hidden');
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