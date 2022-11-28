var bilit = {
    defaultTab: 'box-flight',
    searchBox: '.bilit-search-box',

    init: function()
    {
        bilit.homeSearchTabsListener();
        bilit.changeSortIcon();
        // bilit.mobileFilterToggle();
        bilit.mobileSidebarToggle();
        bilit.mobileOrderDetailsToggle();
        bilit.mobileStickyCheckoutMinMaxTaggle();
        codnitive.dorpdown();
        codnitive.selectAllCheckboxes();
        bilit.persianToEnglishDigits();

        // codnitive.quantity.listener();

        // if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
            if ($.isFunction(window.fastselect)) {
                $('.fastselect').fastselect();
            }
        // }
        if ($.isFunction(window.lazy)) {
            $(function() {
                $('.lazy').Lazy();
            });
        }
    },
    
    loadTabContent: function(tab)
    {
        tab = $(tab);
        var contentWrapper   = $('#' + tab.attr('data-tab-id'));
        if (codnitive.isEmptyElement(contentWrapper)) {
            codnitive.showLoading(contentWrapper, '<i class="fa fa-spinner rotating"></i>در حال دریافت...');
            bilit.ajax(
                codnitive.getBaseUrl() + tab.attr('data-form')
            );
        }
    },

    homeSearchTabsListener: function ()
    {
        $('.homepage').on('click', '.tab-item', function () {
            // bilit.loadTabContent(this);
            var tabId = $(this).prop('id');
            if (tabId == 'box-flight') {
                $('.box-intlflight-about').removeClass('show').addClass('hide');
                $('.box-intlflight-features').removeClass('show').addClass('hide');
                $('.box-flight-about').removeClass('hide').addClass('show');
                $('.box-flight-features').removeClass('hide').addClass('show');
            }
            if (tabId == 'box-intlflight') {
                $('.box-flight-about').removeClass('show').addClass('hide');
                $('.box-flight-features').removeClass('show').addClass('hide');
                $('.box-intlflight-about').removeClass('hide').addClass('show');
                $('.box-intlflight-features').removeClass('hide').addClass('show');
            }
            bilit.changeSlide(this);
        });
    },

    changeSlide: function(_this)
    {
        _this = $(_this);
        $('.home_slider_container .slide.active').removeClass('active');
        var id = _this.prop('id');
        var slide = $('#' + id.replace('box', 'slide'));
        // slide.css('background-image', 'url(/media/images/insurance-slide.jpg)');
        slide.addClass('active');
        
        // change colors
        var home = $('.homepage');
        var currentColor = home.attr('data-current-color');
        var newColor = _this.attr('data-color');
        home.removeClass(currentColor)
            .addClass(newColor)
            .attr('data-current-color', newColor);

        // change page title when changes tab
        document.title = _this.attr('data-page-title');

        // change about
        $('.homepage .about .active').removeClass('active');
        $('#' + id.replace('box', 'about')).addClass('active');
    },

    changeSortIcon: function ()
    {
        $(document).on('click', '.sort-btn', function () {
            var btn = $(this);
            var icon = btn.find('.fa');
            btn.parents('.sorting.bar').find('.sort-btn.active').removeClass('active');
            btn.addClass('active');
            if (icon.hasClass('fa-sort-amount-down')) {
                icon.removeClass('fa-sort-amount-down');
                icon.addClass('fa-sort-amount-up');
            }
            else if (icon.hasClass('fa-sort-amount-up')) {
                icon.removeClass('fa-sort-amount-up');
                icon.addClass('fa-sort-amount-down');
            }
        });
    },

    updateSearchResultCount: function (count)
    {
        $('.search-result-count').html(count);
        $('.still-searching .count').html(count)
    },

    // mobileFilterToggle: function ()
    // {
    //     $('body').on('click', '.filter_toggle_btn', function () {
    //         $('.sidebar').toggleClass('show');
    //     });
    //     $('body').on('click', '.sidebar.show + .sidebar-background', function () {
    //         $('.sidebar').toggleClass('show');
    //     });
    // },

    mobileSidebarToggle: function ()
    {
        $('body').on('click', '.sidebar_toggle_btn', function () {
            $(this).find('i').toggleClass('fa-filter');
            $(this).find('i').toggleClass('fa-times');
            $('.sidebar').toggleClass('show');
        });
        $('body').on('click', '.sidebar.show + .sidebar-background', function () {
            $('.sidebar_toggle_btn i').toggleClass('fa-times');
            $('.sidebar_toggle_btn i').toggleClass('fa-filter');
            $('.sidebar').toggleClass('show');
        });
    },

    mobileOrderDetailsToggle: function ()
    {
        $('body').on('click', '.order-details a', function () {
            $('.sidebar.sticky-box .sidebar-item-box').slideToggle();
            $('.order-details .fa-angle-up, .order-details .fa-angle-down').toggleClass('d-none');
            $('.sidebar.sticky-box .info-box__rules').toggleClass('remove-border');
        });
    },

    mobileStickyCheckoutMinMaxTaggle: function ()
    {
        $('body').on('click', '.sidebar.sticky-box .toggle-card, .sidebar.sticky-box .toggle-card', function () {
            $(this).toggleClass('maximized');
            $(this).find('i').toggleClass('fa-check-circle');
            $(this).find('i').toggleClass('fa-times-circle');
            $('.sidebar.sticky-box').toggleClass('minimized');
            $('.sidebar.sticky-box').toggleClass('show-bg');
        });
        // $('body').on('click', '.sidebar.sticky-box .toggle-card, .sidebar.sticky-box .toggle-card', function () {
        //     $('.sidebar').toggleClass('show-bg');
        // });
    },

    addFieldSetToYiiActiveForm: function (formSelector, index)
    {
        var $form = $(formSelector),
            pattern = formSelector.replace(/#|\./, '') + '_attributes_pattern',
            attributes = $.extend(true, {}, document[pattern]);
        $.each(attributes, function () {
            attribute = this;
            attribute.id = codnitive.clearClone(attribute.id, index);
            attribute.name = codnitive.clearClone(attribute.name, index);
            attribute.input = codnitive.clearClone(attribute.input, index);
            attribute.container = codnitive.clearClone(attribute.container, index);
            $form.yiiActiveForm('add', attribute);
        });
        return this;
    },

    removeFieldSetFromYiiActiveForm: function (formSelector, index)
    {
        var $form = $(formSelector);
        data = $form.data('yiiActiveForm');
        $.each(data.attributes, function(i) {
            if (this.id != undefined && this.id.search(index) !== -1) {
                bilit.unwatchAttribute($form, this);
                delete data.attributes[i];
            }
        });
        data.attributes = data.attributes;
    },

    addFieldToYiiActiveForm: function (formSelector, attribute)
    {
        $(formSelector).yiiActiveForm('add', attribute);
        return this;
    },

    removeFieldFromYiiActiveForm: function (formSelector, attributeId)
    {
        $(formSelector).yiiActiveForm('remove', attributeId);
        return this;
    },

    unwatchAttribute: function ($form, attribute) 
    {
        this.findInput($form, attribute).off('.yiiActiveForm');
    },

    findInput: function ($form, attribute) 
    {
        var $input = $form.find(attribute.input);
        if ($input.length && $input[0].tagName.toLowerCase() === 'div') {
            // checkbox list or radio list
            return $input.find('input');
        } else {
            return $input;
        }
    },

    autoOpenDropdown: function (wrapperSelector, clickedElementSelector, dropdownSelector)
    {
        $(wrapperSelector).on('click', clickedElementSelector + ' .fstResultItem', function () {
            bilit.openDropdown(dropdownSelector);
        });
    },

    openDropdown: function (dropdownSelector)
    {
        // $(dropdownSelector + ' .fstToggleBtn').trigger('click');
        setTimeout(function () {
            $(dropdownSelector + ' .fstToggleBtn').trigger('click');
        }, 100);

        // $('.bilit-search-box').on('DOMSubtreeModified', '.field-insurance-duration .fstControls', function () {
        //     // $('.field-insurance-duration .fstElement').addClass('fstActive');
        //     $('.field-insurance-duration .fstToggleBtn').trigger('click');
        // });
    },

    notify: function (title, message, type, settings)
    {
        $.notify({
            // options
            title: title,
            message: message
        },
        $.extend({
            // settings
            type: 'pastel-'+type,
            placement: {
                from: "bottom",
                align: "right",
            },
            // z_index: 1031,
            delay: 3000,
            timer: 100,
            animate: {
                // enter: '',
                // exit: ''

                enter: 'animated bounceIn',
                // exit: 'animated bounceOut'
                
                // enter: 'animated flipInX',
                exit: 'animated flipOutX'
            },
            mouse_over: 'pause'
        }, settings));
    },

    ajax: function(url, data, method, showReloadConfirm)
    {
        if (data != undefined) {
            data._csrf = yii.getCsrfToken();
        }
        else {
            data = {_csrf: yii.getCsrfToken()};
        }
        codnitive.ajax(url, data, method, showReloadConfirm);
    },

    backTopToSearchAgain: function (selector, wrapper, message)
    {
        $('body').on('click', selector, function() {
            $('body,html').animate({
                scrollTop: 0
            }, 600, function () {
                $(wrapper).html(message);
            });
        });
    },

    scrollTo: function (scrollTo)
    {
        codnitive.scrollTo(scrollTo, 'header.header');
    },

    autoFillForm: function (namespace, data, index, dateFields, dropdownFields)
    {
        for (var key in data) {
            if (data.hasOwnProperty(key)) {
                var id = `#${namespace}-${key}`;
                if (false !== index) {
                    id += `-${index}`;
                }
                
                if ($.inArray(key, dateFields) !== -1) {
                    bilit.autoChangeOrClearMdPersianDateTimePicker(id, data[key])
                }
                else if ($.inArray(key, dropdownFields) !== -1) {
                    bilit.autoChangeFastSelectOption(id, data[key]);
                }
                else {
                    $(id).val(data[key]);
                }
            }
        }
    },

    autoChangeFastSelectOption: function (selector, value)
    {
        var dropdown = $(selector);
        var options = dropdown.data('fastselect').options;
        var parent = dropdown.parents('.form-group');
        dropdown.val(value);
        parent.find('.fstElement').remove();
        parent.parent().find('.fastselect-js-wrapper').remove();
        parent.find('label').after(dropdown);
        parent.find(selector).fastselect(options);
    },

    autoChangeOrClearMdPersianDateTimePicker: function (selector, date)
    {
        date
            ? $(selector).MdPersianDateTimePicker('setDate', new Date(date))
            : $(selector).MdPersianDateTimePicker('clearDate');
    },

    addGridDetailRow: function (_btn, namespace, route)
    {
        _btn = $(_btn);
        var row = _btn.parents('tr');
        var id = row.attr('data-key');
        var newRowIdProp = `${namespace}_${id}`;
        _btn.find('.view, .close-view').toggleClass('d-none');
        if ($('#'+newRowIdProp).length) {
            $('#'+newRowIdProp).toggle();
            return
        }
        
        $.ajax({
            method: 'POST',
            url: codnitive.getBaseUrl() + route,
            data: {
                id: id, 
                admin: $(_btn).attr('data-admin')
            }
        })
        .done(function (response) {
            // response = $.parseJSON(response);
            var block = '';
            for (var key in response) {
                if (response.hasOwnProperty(key)) {
                    block += response[key];
                }
            }
            bilit.addTableRow('tr[data-key='+id+']', block, id, newRowIdProp, namespace);
        })
        .fail(function (response) {
            console.log(response.status + ': ' + response.statusText);
        });
    },

    addTableRow: function(after, content, id, trId, trClass)
    {
        var row  = $(document.createElement('tr')).attr({
            id: trId, 
            class: `${trClass} bg-white`,
            'data-key': id
        });
        var cell = $(document.createElement('td')).attr({colspan: 12})
        cell.html(content).appendTo(row);
        $(after).after(row);
    },

    fieldsSwap: function (fieldsPairs)
    {
        for (key in fieldsPairs) {
            if (fieldsPairs.hasOwnProperty(key)) {
                bilit[key](fieldsPairs[key]);
            }
        }
    },

    inputSwap: function (fieldsPairs)
    {
        for (key in fieldsPairs) {
            if (fieldsPairs.hasOwnProperty(key)) {
                var firstValue = $(key).val();
                $(key).val($(fieldsPairs[key]).val());
                $(fieldsPairs[key]).val(firstValue);
            }
        }
    },

    inputFastselectSwap: function (fieldsPairs)
    {
        for (key in fieldsPairs) {
            if (fieldsPairs.hasOwnProperty(key)) {
                var firstTextKey = `${key} .fstToggleBtn`;
                var secondTextKey = `${fieldsPairs[key]} .fstToggleBtn`;
                var firstValue  = $(firstTextKey).text();
                var secondValue = $(secondTextKey).text();

                $(firstTextKey).text(secondValue);
                $(secondTextKey).text(firstValue);
                bilit.inputFastselectChangeOption(key, secondValue);
                bilit.inputFastselectChangeOption(fieldsPairs[key], firstValue);
            }
        }
    },

    inputFastselectChangeOption: function (wrapper, value) 
    {
        $(`${wrapper} .fstResults .fstResultItem.fstSelected`).removeClass('fstSelected');
        $(`${wrapper} .fstResults .fstResultItem`).each(function (i) {
            if ($(this).text() == value) {
                $(this).addClass('fstSelected');
            }
        })
    },

    // dropdownFastselectSwap: function (fieldsPairs)
    // {
    //     for (key in fieldsPairs) {
    //         if (fieldsPairs.hasOwnProperty(key)) {
    //             var firstValue = $(key).val();
    //             bilit.autoChangeFastSelectOption(key, $(fieldsPairs[key]).val());
    //             bilit.autoChangeFastSelectOption(fieldsPairs[key], firstValue);
    //         }
    //     }
    // },

    persianToEnglishDigits: function () 
    {
        $('body').on('keyup', 'input, .enligsh-digits', function () {
            let input = $(this);
            input.val(input.val().toEnglishDigits());
        });
    },

    confirm: function(callback, options)
    {
        swal($.extend({
            title: "Are you sure?",
            icon: "warning",
            buttons: ['خیر', 'بله'],
            dangerMode: true,
        }, options))
        .then((confirm) => {
            console.log(callback);
            if (confirm) {
                callback();
            }
        });
    },
}

$(document).ready(function() {
    bilit.init();
    /*if ($('#box-bus').length) {
        bilit.loadTabContent($('#box-bus'));
        $('.homepage').addClass('pink');
        $('.homepage').attr('data-current-color', 'pink');
    }*/
    var tab = codnitive.getUrlParam('tab');
    if (undefined == tab) {
        tab = bilit.defaultTab;
    }
    $('#' + tab).trigger('click');
    $('.homepage').on('click', '#tab-hotel #searchform-destination_type input', function () {
        var typeId = $(this).val();
        if (typeId == 1) {
            $('.box-intlhotel-about').removeClass('hide').addClass('show');
            $('.box-intlhotel-features').removeClass('hide').addClass('show');
            $('.box-hotel-about').removeClass('show').addClass('hide');
            $('.box-hotel-features').removeClass('show').addClass('hide');
        }
        if (typeId == 2) {
            $('.box-hotel-about').removeClass('hide').addClass('show');
            $('.box-hotel-features').removeClass('hide').addClass('show');
            $('.box-intlhotel-about').removeClass('show').addClass('hide');
            $('.box-intlhotel-features').removeClass('show').addClass('hide');
        }
    });

    $('.homepage .bilit-search-box form').on('click', function(){
		$('body,html').animate({
			scrollTop: 300
		}, 600);
    });
    
    // $('body').on('click', '.disabled', function (e) {
    //     e.preventDefault();
    //     return false;
    // });
});
