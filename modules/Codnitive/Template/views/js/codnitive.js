// (function($){
codnitive = {
    // baseUrl: 'http://www.tixox.com/', // @TODO change URL
    // baseUrl: 'http://tixox.loc/',
    baseUrl: BASE_URL,

    init: function()
    {
        this.tabClick();
        this.fieldsetCloneQtyControl();
        this.fieldQtyChangeButtonsListener();
    },

    getBaseUrl: function ()
    {
        var baseUrl = codnitive.baseUrl;
        if (baseUrl.slice(-1) != '/') {
            baseUrl += '/';
        }
        return baseUrl;
    },

    tabClick: function()
    {
        $(document).on('click', '.tab-item', function () {
            codnitive.changeTab(this);
        });
        return this;
    },

    autoChangeTab: function()
    {
        // // var hash = window.location.hash.substr(1);
        // var hash = window.location.hash;

        var keyValuePair = document.location.search.substr(1).split('&');
        if (keyValuePair == '') {
            return;
        }

        var i = keyValuePair.length;
        var param;
        var tab;
        while (i--) {
            param = keyValuePair[i].split('=');
            if (param[0] == 'tab') {
                tab = param[1];
                break;
            }
        }
        if (!tab) {
            return;
        }
        codnitive.changeTab($('#'+tab));
    },

    changeTab: function(_this)
    {
        _this = $(_this);
        if (tab = _this.prop('id')) {
            codnitive.updateUrlTab(tab);
        }
        var tabContent = _this.attr('data-tab-id');
        var content = $('#' + tabContent);
        _this.parent('.tab-items').children('.active').removeClass('active');
        _this.addClass('active');
        content.parent('.tab-wrapper').children('.tab-active').removeClass('tab-active');
        content.addClass('tab-active');
        return this;
    },

    updateUrlTab: function(tab)
    {
        var urlSearch = codnitive.insertUrlParam('tab', tab, false);
        if (document.location.search.substr(1) != urlSearch) {
            var historyState = new codnitive.historyState();
            historyState.replaceSearch(urlSearch);
        }
    },

    collapseBlock: function(button, content, wrapper)
    {
        if (!button) {
            button = '.collapse-button';
        }
        if (!content) {
            content = '.collapse-content';
        }
        if (!wrapper) {
            wrapper = '.collapse-wrapper';
        }
        $('.collapse-button').on('click', function () {
            var item = $(this);
            item.parents('.collapse-wrapper').find('.collapse-content').slideToggle(150);
        });
        return this;
    },

    initDatePicker: function(block, format)
    {
        // if (format === undefined) {
        //     format = 'Y-m-d';
        // }
        format = format || 'Y-m-d';
        $(block).find('input.datepicker').each(function() {
            var datepicker = $(this);
            datepicker.Zebra_DatePicker({
                // format: 'Y-m-d H:i',
                format: format,
                show_icon: false,
                direction: true,
                offset: [-255, 285],
                onSelect: function () {
                    codnitive.updateDatepickerDirection(datepicker);
                }
            });
        });
        return this;
    },

    updateDatepickerDirection: function(element)
    {
        var id = element.prop('id');
        if (element.hasClass('from-date')) {
            id = id.search('start')
                ? id.replace('start', 'end')
                : id.replace('from', 'to');
            var fromDate   = element.val();
            var datepicker = $('#'+id).data('Zebra_DatePicker');
            datepicker.update({
                direction: [fromDate, false]
            });
        }
    },

    initTimePicker: function(block)
    {
        $(block).find('.clockpicker').each(function () {
            var clockpicker = $(this);
            clockpicker.clockpicker({
                donetext: 'Done',
                autoclose: true,
                default: 'now',
                afterDone: function () {
                    clockpicker.val(clockpicker.val()+':00');
                }
            });
        });
        return this;
    },

    initWysiwygEditor: function(block)
    {
        $(block).find('textarea.text-editor').each(function () {
            CKEDITOR.replace(this);
        });
        return this;
    },

    initFileinput: function(block)
    {
        // $(block).find('input.file-input').each(function () {
        $(block).find('input[type=file]').each(function () {
            var input = $(this);
            var krajeeFileinput = input.attr('data-krajee-fileinput');
            if (input.data('fileinput')) {
                input.fileinput('destroy');
            }
            input.fileinput(window[krajeeFileinput]);
        });
        return this;
    },

    getTimeRemaining: function(endtime)
    {
        var t       = Date.parse(endtime) - Date.parse(new Date());
        if (t < 0) {
            return {
                'total': 0
            };
        }
        var seconds = Math.floor((t / 1000) % 60);
        var minutes = Math.floor((t / 1000 / 60) % 60);
        var hours   = Math.floor((t / (1000 * 60 * 60)) % 24);
        var days    = Math.floor(t / (1000 * 60 * 60 * 24));
        return {
            'total':   t,
            'days':    days,
            'hours':   hours,
            'minutes': minutes,
            'seconds': seconds
        };
    },

    initializeCountdown: function(id, endtime, parts)
    {
        if (parts == undefined) {
            parts = {
                days: true, 
                hours: true, 
                minutes: true, 
                seconds: true, 
            };
        }
        var clock       = document.getElementById(id);

        if (parts.days) {
            var daysSpan    = clock.querySelector('.days');
        }
        if (parts.hours) {
            var hoursSpan   = clock.querySelector('.hours');
        }
        if (parts.minutes) {
            var minutesSpan = clock.querySelector('.minutes');
        }
        if (parts.seconds) {
            var secondsSpan = clock.querySelector('.seconds');
        }

        function updateClock() {
            var t = codnitive.getTimeRemaining(endtime);
            if (t.total <= 0) {
                clearInterval(timeinterval);
                return;
            }

            if (parts.days) {
                daysSpan.innerHTML    = ('00' + t.days).slice(-3);
            }
            if (parts.hours) {
                hoursSpan.innerHTML   = ('0'  + t.hours).slice(-2);
            }
            if (parts.minutes) {
                minutesSpan.innerHTML = ('0'  + t.minutes).slice(-2);
            }
            if (parts.seconds) {
                secondsSpan.innerHTML = ('0'  + t.seconds).slice(-2);
            }

            // if (t.total <= 0) {
            //     clearInterval(timeinterval);
            // }
        }

        updateClock();
        var timeinterval = setInterval(updateClock, 1000);
    },
    
    getUrlParam: function (sParam) 
    {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;
    
        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');
    
            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined 
                    ? true 
                    : decodeURIComponent(sParameterName[1]);
            }
        }
    },

    insertUrlParam: function(key, value, multiple, keyValuePair)
    {
        key   = encodeURIComponent(key);
        value = encodeURIComponent(value);
        if (!keyValuePair) {
            keyValuePair = document.location.search.substr(1);
        }
        keyValuePair = keyValuePair.split('&');
        if (keyValuePair == '') {
            return '?' + key + '=' + value;
        }

        var i = keyValuePair.length;
        var param;
        while (i--) {
            param = keyValuePair[i].split('=');
            if (param[0] == key) {
                param[1] = multiple ? param[1] + ',' + value : value;
                param[1] = param[1].replace(/^,|,$/gm,'');
                keyValuePair[i] = param.join('=');
                break;
            }
        }
        if (i < 0) {
            keyValuePair[keyValuePair.length] = [key, value].join('=');
        }

        return keyValuePair.join('&');
    },

    // <<< add form field set
    addFieldSet: function(tabContentSelector, contentDestination, tabDestination)
    {
        var tabContent  = $(tabContentSelector);
        var pattern     = tabContent.find('.tab-pattern-wrapper');
        var baseContent = pattern.find('.tab-content-wrapper');
        var index       = parseInt(pattern.attr('data-index'));
        var contentHtml = codnitive.clearClone(baseContent.html(), index);

        contentDestination = contentDestination || '.tab-contents';
        // if (contentDestination === undefined) {
        //     contentDestination = '.tab-contents';
        // }
        tabContent.find(contentDestination).append(contentHtml);
        // tabContent.find(contentDestination).find('#row-'+index).attr('data-fieldset', tabContentSelector);
        bilit.addFieldSetToYiiActiveForm(tabContent.attr('data-form'), index);
        pattern.attr('data-index', index+1);
        return index;
    },

    removeFieldSet: function (id)
    {
        var msg = 'Are you sure you want delete it?';
        if (!confirm(msg)) {
            return false;
        }
        var row = $('#'+id);
        row.remove();
        var index = id.match(/\d+/)[0];
        bilit.removeFieldSetFromYiiActiveForm($(row.attr('data-fieldset')).attr('data-form'), index);

        return codnitive.updateFiedlsetTitleQty(row.attr('data-fieldset'), -1);
    },

    clearClone: function(str, index, pattern)
    {
        if (str === undefined) {
            return str;
        }
        if (pattern === undefined) {
            pattern = /9999999999/g;
        }
        return str.replace(pattern, index)
                .replace(/text-area/g, 'textarea')
                .replace(/fi-le/g, 'file');
    },

    fieldsetCloneQtyControl: function ()
    {
        $('body').on('click', '.fieldset-clone-rows-control .qtyplus, .fieldset-clone-rows-control .qtyminus', function () {
            var _this           = $(this),
                _parent         = _this.parent('.fieldset-clone-rows-control'),
                fieldSetWrapper = _this.attr('data-fieldset');
            var qtyField = _parent.children('.qty-field');
//            if (_this.val() == '+') {
            if (_this.attr('data-value') == '+') {
                var qty = parseInt(qtyField.val()) + 1;
                var qtyChange = 1;
                if (qty > _this.attr('data-max')) {
                    return;
                }
                codnitive.addFieldSet(fieldSetWrapper);
            }
//            else if (_this.val() == '-') {
            else if (_this.attr('data-value') == '-') {
                var qtyChange = -1;
                minQty  = _this.attr('data-min') || 0;
                if (qty < minQty) {
                    return;
                }
                $(fieldSetWrapper).find('.tab-contents .fieldset-row:last-child').remove();
            }
//            qtyField.val(qty);
            codnitive.updateFiedlsetTitleQty(fieldSetWrapper, qtyChange);
        });
    },

    updateFiedlsetTitleQty: function (fieldsetWrapper, qtyChange, qtyField, qty)
    {
        var fieldSetTitles = $(fieldsetWrapper).find('.title-qty'),
            qtyControl = $(fieldsetWrapper.replace('#', '.')+'-qty-control'),
            qtyField = $(qtyControl).find('.qty-field'),
            qty = qty || parseInt(qtyField.val()) + parseInt(qtyChange);
        for (i = 1; i <= qty; i++) {
            $(fieldSetTitles[i-1]).text(i);
        }

        var plus = qtyControl.find('.qtyplus'),
            minus = qtyControl.find('.qtyminus'),
            maxQty = plus.attr('data-max'),
            minQty = minus.attr('data-min') || 0;
        
        qty == maxQty 
            ? plus.attr('disabled', 'disabled')
            : plus.removeAttr('disabled');
        qty == minQty 
            ? minus.attr('disabled', 'disabled')
            : minus.removeAttr('disabled');
        
        qtyField.val(qty);
        return qty;
    },
    // >>> add form field set

    cloneHtml: function(sample, destination, index)
    {
        sample = $(sample);
        index  = index || parseInt(sample.attr('data-index'));
        var contentHtml = codnitive.clearClone(sample.html(), index);
        $(destination).append(contentHtml);
        sample.attr('data-index', index+1);
    },

    // removeFieldSet: function (id, cloneSample)
    // {
    //     var msg = 'Are you sure you want delete it?';
    //     if (!confirm(msg)) {
    //         return false;
    //     }
    //     $('#'+id).remove();
    //     var tabItem = $('[data-tab-id='+id+']');
    //     var tabItemsWrapper = tabItem.parent('.tab-items');
    //     tabItem.remove();
    //     var firstTabItem = tabItemsWrapper.children('.tab-item:first-child');
    //     codnitive.changeTab(firstTabItem);
    //     return !cloneSample;
    // },

    clearClone: function(str, index, pattern)
    {
        if (str === undefined) {
            return str;
        }
        if (pattern === undefined) {
            pattern = /9999999999/g;
        }
        return str.replace(pattern, index)
                .replace(/text-area/g, 'textarea')
                .replace(/fi-le/g, 'file');
    },

    changePerPage: function()
    {
        $('.per-page-wrapper .page-size').on('change', function () {
            var sizeOption = $(this);
            var newParams = codnitive.insertUrlParam('per-page', sizeOption.val());
            codnitive.refreshSearchUrl(newParams);
        });
    },

    changeListSort: function()
    {
        $('#list_sort').on('change', function () {
            var sortOption = $(this);
            var newParams = codnitive.insertUrlParam('sort', sortOption.val());
            codnitive.refreshSearchUrl(newParams);
        });
    },

    changeFilter: function()
    {
        $('.filter input, .filter select').on('change', function () {
            // alert(this.defaultValue);
            // alert(this.value);
            var _this = this;
            var filterOption = $(_this);
            var isCheckbox   = filterOption.prop('type') === 'checkbox';
            // var filterField  = filterOption.attr('name').match(/\w+/gi);
            var filterField = codnitive.getSearchField(filterOption);
            var filterLabel  = '';
            if (_options = _this.options) {
                filterLabel = _options[_this.selectedIndex].text;
            }
            else if (filterOption.prop('type') == 'text') {
                filterLabel = filterOption.val().trim();
            }
            else if (filterOption.is(':checked')) {
                filterLabel = codnitive.getCheckFieldLabel(filterOption);
            }
            if (filterLabel === '') {
                var value = isCheckbox
                    ? codnitive.getCheckFieldLabel(filterOption)
                    : _this.defaultValue;
                var newParams   = codnitive.removeUrlParam(
                    filterField,
                    value,
                    isCheckbox
                );
                codnitive.refreshSearchUrl(newParams);
                return;
            }

            if (filterField == 'event_price_type' && filterLabel === 'Paid') {
                codnitive.togglePriceSlider(_this);
                return;
            }

            var newParams   = codnitive.insertUrlParam(
                filterField,
                filterLabel,
                isCheckbox
            );

            if (filterField == 'event_price_type' && filterLabel === 'Free') {
                newParams = codnitive.removeUrlParam('price_range', '', false, newParams);
            }
            if (filterField == 'when') {
                newParams = codnitive.removeUrlParam('event_start_date', '', false, newParams);
                newParams = codnitive.removeUrlParam('event_end_date', '', false, newParams);
            }
            
            codnitive.refreshSearchUrl(newParams);
        });
        return this;
    },

    removeUrlParam: function(key, value, multiple, keyValuePair)
    {
        key   = encodeURIComponent(key);
        value = encodeURIComponent(value);
        if (!keyValuePair) {
            keyValuePair = document.location.search.substr(1);
        }
        keyValuePair = keyValuePair.split('&');
        if (keyValuePair == '') {
            return null;
        }

        var i = keyValuePair.length;
        var param;
        while (i--) {
            param = keyValuePair[i].split('=');
            if (param[0] == key) {
                if (multiple) {
                    param[1] = param[1].replace(value, '').replace(',,', ',').replace(/^,|,$/gm,'');
                }
                if (multiple && param[1]) {
                    keyValuePair[i] = param.join('=');
                }
                else {
                    keyValuePair.splice(i, 1);
                }
                break;
            }
        }
        // if (i < 0) {
        //     keyValuePair[keyValuePair.length] = [key, value].join('=');
        // }

        if (keyValuePair == '') {
            return null;
        }
        return keyValuePair.join('&');

        // var search = document.location.search;
        // var param = (search.search('&' + key) !== -1)
        //     ? ('&' + key + '=' + value)
        //     : (key + '=' + value);
        // search = search.replace(param, '').replace('?&', '?');
        // var keyValuePair = search.substr(1).split('&');
        // if (keyValuePair == '') {
        //     search = null;
        // }
        // return search;
    },

    removeFilter: function()
    {
        // $('.filter input[type="checkbox"]:checked, \
        $('.filter input[type="radio"]:checked').on('click', function () {
            // alert(this.defaultValue);
            // alert(this.value);
            var _this = this;
            var filterField = codnitive.getSearchField(_this);
            var filterLabel = codnitive.getCheckFieldLabel(_this);
            var newParams   = codnitive.removeUrlParam(
                filterField,
                filterLabel,
                ($(_this).prop('type') === 'checkbox')
            );
            if (filterField == 'event_price_type' && newParams) {
                newParams = codnitive.removeUrlParam(
                    'price_range',
                    '',
                    false,
                    newParams
                );
            }
            codnitive.refreshSearchUrl(newParams);
        });
        return this;
    },

    searchCustomDate: function()
    {
        var filterStartDate = $('.filter #search-event_start_date');
        codnitive.updateDateSearch(filterStartDate);

        var filterEndDate = $('.filter #search-event_end_date');
        codnitive.updateDateSearch(filterEndDate);
        // codnitive.updateDatepickerDirection(filterStartDate);

        // $('.filter .btn-primary.filter-date').on('click', function() {
        //     var newParams  = null;
        //
        //         // alert($('#search-event_start_date').prop('defaultValue'));
        //         // alert($('#search-event_start_date').prop('value'));
        //     var defaultStartDate = $('#search-event_start_date').prop('defaultValue');
        //     var defaultEndDate   = $('#search-event_end_date').prop('defaultValue');
        //
        //     var startDate = $('#search-event_start_date').val();
        //     var endDate   = $('#search-event_end_date').val();
        //     /*if (startDate && endDate) {
        //         var value = startDate + '_' + endDate;
        //         newParams  = codnitive.insertUrlParam('custom_date', value);
        //     }
        //     else */
        //     if (startDate && (startDate != defaultStartDate)) {
        //         newParams  = codnitive.insertUrlParam('event_start_date', startDate);
        //     }
        //     if (endDate && (endDate != defaultEndDate)) {
        //         newParams  = codnitive.insertUrlParam('event_end_date', endDate);
        //     }
        //     if (!newParams) {
        //         return;
        //     }
        //     codnitive.refreshSearchUrl(newParams);
        // });
        return this;
    },

    updateDateSearch: function(filterDatepicker, isEndDate)
    {
        filterDatepicker = $(filterDatepicker);
        if (!filterDatepicker.hasClass('datepicker')) {
            return;
        }
        var datepickerConfig = {
            onSelect: function(view, elements) {
                var _this = $(this);
                var oldDate = _this.prop('defaultValue');
                var newDate = _this.prop('value');
                if (oldDate == newDate) {
                    return;
                }
                var filterField = codnitive.getSearchField(_this);
                var newParams   = codnitive.insertUrlParam(filterField, newDate);
                newParams = codnitive.removeUrlParam('when', '', false, newParams);
                codnitive.refreshSearchUrl(newParams);
            },
            onClear: function() {
                var _this       = $(this);
                var filterField = codnitive.getSearchField(_this);
                var newParams   = codnitive.removeUrlParam(filterField, '', false);
                codnitive.refreshSearchUrl(newParams);
            }
        };
        if (filterDatepicker.hasClass('to-date')) {
            var id = filterDatepicker.prop('id').replace('end', 'start');
            var startDate = $('#'+id).val();
            datepickerConfig.direction = [startDate, false];
        }
        // $('.filter .datepicker').Zebra_DatePicker({
        filterDatepicker.data('Zebra_DatePicker').update(datepickerConfig);
    },

    getCheckFieldLabel: function(element)
    {
        var id = $(element).prop('id');
        return $('label[for="'+id+'"]').text().trim();
    },

    getSearchField: function(element)
    {
        return $(element).attr('name').match(/\w+/gi)[1];
    },

    refreshSearchUrl: function(newParams)
    {
        if (newParams == null) {
            var url = window.location.href;
            window.location.href = url.split('?')[0];
            return;
        }
        document.location.search = newParams;
    },

    togglePriceSlider: function(_this)
    {
        // $('.filter input[name="Search[price_type]"]').click(function () {
            var priceInput = $(_this);
            if (parseInt(priceInput.val())) {
                $('#price-range').show();
            }
            else {
                $('#price-range').hide();
            }
        // });
        return this;
    },

    initSlider: function()
    {
        // $(function () {
        var priceSlider = $("#price-slider");
        if (!priceSlider.prop('id')) {
            return;
        }
        var min = parseFloat(priceSlider.attr('data-min'));
        var max = parseFloat(priceSlider.attr('data-max'));
        var values = priceSlider.attr('data-values').split('-');
        priceSlider.slider({
            animate: true,
            range: true,
            step: 10,
            min: min,
            max: max,
            values: values,
            slide: function (event, ui) {
                codnitive.initSliderPrice(ui.values[0], ui.values[1]);
            },
            change: function (event, ui) {
                var min   = ui.values[0];
                var max   = ui.values[1];
                var range = min + '-' + max;
                var newParams   = codnitive.insertUrlParam('event_price_type', 'Paid');
                newParams       = codnitive.insertUrlParam('price_range', range, false, newParams);
                codnitive.refreshSearchUrl(newParams);
            },
        });
        var minPriceFitlered = priceSlider.slider('values', 0);
        var maxPriceFitlered = priceSlider.slider('values', 1);
        codnitive.initSliderPrice(minPriceFitlered, maxPriceFitlered);
        // });
        return this;
    },

    initSliderPrice: function(min, max)
    {
        $("#amount").val(min + '$' + ' - ' + max + '$');
        return this;
    },

    scrollTo: function(scrollTo, stickyHeader, container, time)
    {
        container = container || 'html, body';
        time = time || 250;
        container = $(container);
        scrollTo  = $(scrollTo);

        if (scrollTo.offset()) {
            if (typeof stickyHeader === "string") {
                var stickyHeaderHeight = stickyHeader != undefined
                    ? parseInt($(stickyHeader).outerHeight())
                    : 0;
            }
            else {
                var stickyHeaderHeight = parseInt(stickyHeader);
            }
            container.animate({
                scrollTop: scrollTo.offset().top - stickyHeaderHeight
            }, time);
        }
        return this;
    },

    linkAutoScroll: function ()
    {
        $("a[href^='#']:not(a[data-toggle='collapse'])").on('click', function(e) {
            e.preventDefault();
            var element = this;
            var hash    = element.hash;
            if (hash) {
                codnitive.scrollTo(hash);
            }
            // var hash = this.hash;
            // $('html, body').animate({
            //  scrollTop: $(this.hash).offset().top
            // }, 200);
        });
    },

    trim: function(str)
    {
        return str.replace(/^\s+|\s+$/gm, '');
    },

    location: 
    {
        autocomplete: null,
        searchElement: null,

        initAutocomplete: function(elementId)
        {
            if (!elementId) {
                elementId = 'autocomplete';
            }
            codnitive.location.searchElement = document.getElementById(elementId);
            // var field = codnitive.location.locationField
            //     ? codnitive.location.locationField
            //     : document.getElementById('autocomplete');
            codnitive.location.autocomplete = new google.maps.places.Autocomplete(
                // field,
                codnitive.location.searchElement,
                // document.getElementsByClassName('search-field')[0],
                {types: ['geocode']}
            );
            codnitive.location.autocomplete.addListener('place_changed', codnitive.location.fillInAddress);
        },

        fillInAddress: function()
        {
            var place = codnitive.location.autocomplete.getPlace();
            // console.log("place : ", place)
            // console.log(place);
            // locationFullName = '';
            // for (var i = 0; i < place.address_components.length; i++) {
            //     locationFullName = (i === 0)
            //         ? locationFullName + place.address_components[i]['long_name']
            //         : locationFullName + ", " + place.address_components[i]['long_name'];
            // }
            // locationFullName = place.address_components[0]['long_name']
            //     + ', ' + place.address_components[place.address_components.length-3]['long_name']
            //     + ', ' + place.address_components[place.address_components.length-2]['short_name'];
            // codnitive.location.fillSelectedSuggestion(place.adr_address);
            codnitive.location.fillSelectedSuggestion(place);
            // alert($(codnitive.location.searchElement).val());
//
            // document.getElementById('result-id').innerHTML = fullName;
            // document.getElementById('autocomplete').style.display = 'none';
            // document.getElementById('result-id').style.display = 'inline-block';
            // document.getElementById('result-title-id').style.display = 'inline-block';


        },

        geolocate: function ()
        {
            // console.log("navigator.geolocation : ", navigator.geolocation)
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    codnitive.location.codeLatLng(
                        position.coords['latitude'],
                        position.coords['longitude']
                    );
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    codnitive.location.autocomplete.setBounds(circle.getBounds());
                });
            }
            codnitive.location.loadMorePopularEvents(1);
        },

        codeLatLng: function(lat, lng)
        {
            var geocoder = new google.maps.Geocoder;
            var latlng = new google.maps.LatLng(lat, lng);
            geocoder.geocode({'latLng': latlng}, function(results, status) {
                // locationFullName = results[0]['formatted_address'];
                // locationFullName = results[0]['adr_address'];
                codnitive.location.fillSelectedSuggestion(results[0]);
            });
        },

        getFullAddressComponents: function(addressComponents)
        {
            var fullLocation = '';
            var longName, shortName;
            for (var i = 0; i < addressComponents.length; i++) {
                longName = addressComponents[i]['long_name'];
                shortName = addressComponents[i]['short_name'];
                fullLocation += (longName + ', ');
                if (longName != shortName) {
                    fullLocation += (shortName + ', ');
                }
            }
            return codnitive.trim(fullLocation).replace(/,$/gm, '');
        },

        fillSelectedSuggestion: function(location, locationFieldWrapper)
        {
            // var locationFullName = location['formatted_address'];
            // var locationFullName = location['adr_address'];
                // ? location['adr_address']
                // : location.adr_address;
            if (!locationFieldWrapper) {
                locationFieldWrapper = '.location-suggestion'
            }

            var searchElement    = $(codnitive.location.searchElement);
            var isFullLocation   = searchElement.hasClass('full-location');

            locationFieldWrapper = $(locationFieldWrapper);
            var searchField      = locationFieldWrapper.find('.search-field');
            var locationFullName = searchField.val();
            if (!locationFullName && !isFullLocation) {
                return;
                // $('.pac-container > .pac-item').trigger('click');
            }

            var locationNameBlock = locationFieldWrapper.find('.location-name');
            if (locationNameBlock.hasClass('location-name')) {
                locationNameBlock.html(locationFullName);
                locationNameBlock.css('display', 'inline-block');
                locationFieldWrapper.find('.result-title').css('display', 'inline-block');
                locationFieldWrapper.find('.postal-code').css('display', 'none');
                searchField.css('display', 'none');
                // searchField.val(locationFullName);
                codnitive.location.searchLocation();
            }

            if (isFullLocation) {
                var id = searchElement.prop('id').replace('_hidden', '');
                var addressComponents = codnitive.location.getFullAddressComponents(
                    location.address_components
                );
                var fullLocation = searchElement.val() + '; '
                       + location['formatted_address'] + '; '
                       + addressComponents;
                $('#'+id).val(fullLocation);
            }
            return this;

            // document.getElementById('result-id').innerHTML = locationFullName;
            // document.getElementById('autocomplete').style.display = 'none';
            // document.getElementById('result-id').style.display = 'inline-block';
            // document.getElementById('result-title-id').style.display = 'inline-block';
        },

        clearSelectedSuggestion: function(locationFieldWrapper)
        {
            if (!locationFieldWrapper) {
                locationFieldWrapper = '.location-suggestion'
            }
            locationFieldWrapper = $(locationFieldWrapper);
            locationFieldWrapper.find('.location-name').css('display', 'none');
            locationFieldWrapper.find('.result-title').css('display', 'none');
            locationFieldWrapper.find('.search-field').css('display', 'inline-block');
            // locationFieldWrapper.find('.search-field').val('');
            return this;

            // document.getElementById('autocomplete').value = '';
            // document.getElementById('autocomplete').style.display = 'inline-block';
            // document.getElementById('result-id').style.display = 'none';
            // document.getElementById('result-title-id').style.display = 'none';
        },

        searchLocation: function(page, type)
        {
            if (!page) {
                page = 1;
            }
            if (!type) {
                type = 'html';
            }
            var searchElement = $(codnitive.location.searchElement);
            var data = {
                'event_location': searchElement.val(),
                'page': page,
                'type': type
            };
            codnitive.ajax(
                codnitive.baseUrl+'event/ajax/popularLocations',
                data
            );
        },

        loadMorePopularEvents: function(page)
        {
            // $('#more_popular_events').on('click', function () {
                // var page = $(loader).attr('data-page');
                codnitive.location.searchLocation(page, 'append');
            // });
        }
    },

    ajax: function(url, data, method, showReloadConfirm)
    {
        showReloadConfirm = showReloadConfirm === undefined ? true : showReloadConfirm;
        method = method || 'POST';
        $.ajax({
            method: method,
            url: url,
            data: data
        })
        .done(function (response) {
            // response = $.parseJSON(response);
            var block;
            // console.log(response);
            for (var key in response) {
                if (response.hasOwnProperty(key)) {
                    block = response[key];
                    codnitive.addElement(block.element, block.type, block.content);
                    $(block.element).trigger(block.element + ':ajaxUpdateSuccess');
                }
            }
            // codnitive.addElement(response.element, response.type, response.content);
            $(document).trigger('codnitive:ajaxDone:' + url);
        })
        .fail(function (response) {
            // console.log(response.responseText);
            var msg = response.status + ': ' + response.statusText;
            console.log(msg);
            // if (showReloadConfirm && confirm(msg + "\nRefresh the page?")) {
            //     location.reload();
            // }
            $(document).trigger('codnitive:ajaxFail:' + url);
        });
        return this;
    },

    addElement: function(parent, type, content)
    {
        var parent = $(parent);
        switch (type) {
            case 'html':
                parent.html(content);
                break;

            case 'text':
                parent.text(content);
                break;

            case 'append':
                parent.append(content);
                break;

            case 'prepend':
                parent.prepend(content);
                break;

            case 'value':
                parent.val(content);
                break;

            case 'alert':
                alert(content);
                break;

            case 'swal':
                swal(content);
                break;
        }
        return this;
    },

    bookmark: function()
    {
        // $('#bookmarkme').click(function() {
            if (window.sidebar && window.sidebar.addPanel) { // Mozilla Firefox Bookmark
              window.sidebar.addPanel(document.title, window.location.href, '');
            } else if (window.external && ('AddFavorite' in window.external)) { // IE Favorite
              window.external.AddFavorite(location.href, document.title);
            } else if (window.opera && window.print) { // Opera Hotlist
              this.title = document.title;
              return true;
            } else { // webkit - safari/chrome
            //   alert('Press ' + (navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? 'Command/Cmd' : 'CTRL') + ' + D to bookmark this page.');
                swal('Press ' + (navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? 'Command/Cmd' : 'CTRL') + ' + D to bookmark this page.');
            }
        // });
    },
    
    // quantity: 
    // {
    //     min      : 0,
    //     max      : 10,
    //     step     : 1,
    //     button   : null,
    //     input    : null,
    //     type     : null,
    //     minusBtn : null,
    //     plusBtn  : null,
    //     oldValue : null,

    //     _construct: function(obj)
    //     {
    //         codnitive.quantity.button = $(obj);
    //         codnitive.quantity._init();
    //         codnitive.quantity.changeQty();
    //     },

    //     _init: function()
    //     {
    //         var _qtyObj   = codnitive.quantity;
    //         var wrapper   = _qtyObj.button.parents('.quantity-ctl');
    //         _qtyObj.type  = _qtyObj.button.attr('data-type');

    //         _qtyObj.input    = wrapper.find('input.qty');
    //         _qtyObj.minusBtn = wrapper.find('[data-type=minus]');
    //         _qtyObj.plusBtn  = wrapper.find('[data-type=plus]');
    //         _qtyObj.setMin().setMax().setStep();
    //     },

    //     changeQty: function()
    //     {
    //         var _qtyObj  = codnitive.quantity;
    //         var input    = _qtyObj.input;
    //         var value    = parseFloat(input.val());

    //         switch(codnitive.quantity.type) {
    //             case 'minus':
    //                 if (value > _qtyObj.min) {
    //                     value -= _qtyObj.step;
    //                 }
    //                 break;

    //             case 'plus':
    //                 if (value < _qtyObj.max) {
    //                     value += _qtyObj.step;
    //                 }
    //                 break;
    //         }

    //         if (value >= _qtyObj.min && value <= _qtyObj.max) {
    //             input.val(value);
    //             _qtyObj.changeQtyBtns(value);
    //             return true;
    //         }
    //         input.val(_qtyObj.oldValue);
    //         alert('Invalid Value');
    //         return false;
    //     },

    //     changeQtyBtns: function(value)
    //     {
    //         var _qtyObj = codnitive.quantity;
    //         if (value >= _qtyObj.max) {
    //             _qtyObj.plusBtn.attr("disabled", true);
    //         }
    //         if (value > _qtyObj.min) {
    //             _qtyObj.minusBtn.attr("disabled", false);
    //         }
    //         if (value < _qtyObj.max) {
    //             _qtyObj.plusBtn.attr("disabled", false);
    //         }
    //         if (value <= _qtyObj.min) {
    //             _qtyObj.minusBtn.attr("disabled", true);
    //         }
    //     },

    //     setMin: function()
    //     {
    //         if (min = parseFloat(codnitive.quantity.minusBtn.attr('data-min'))) {
    //             codnitive.quantity.min = min;
    //         }
    //         return this;
    //     },

    //     setMax: function()
    //     {
    //         if (max = parseFloat(codnitive.quantity.plusBtn.attr('data-max'))) {
    //             codnitive.quantity.max = max;
    //         }
    //         return this;
    //     },

    //     setStep: function()
    //     {
    //         if (step = parseFloat(codnitive.quantity.input.attr('data-step'))) {
    //             codnitive.quantity.step = step;
    //         }
    //         return this;
    //     },

    //     listener: function()
    //     {
    //         $('body').on('click', '.quantity-ctl .btn-number', function () {
    //             codnitive.quantity._construct(this);
    //         });

    //         $('body').on('focusin', '.quantity-ctl .qty', function(){
    //             codnitive.quantity.oldValue = this.value;
    //         }).on('change', '.quantity-ctl .qty', function () {
    //             codnitive.quantity._construct(this);
    //         });
    //     }
    // },

    /**
     * needs jQuery Validation plugin installed
     * 
     * https://jqueryvalidation.org/
     * 
     * @form        form selection
     * @submit      button which will click for validate form
     * @callback    callback function to run in valid case
     * 
     * @sample
     * 
     *   codnitive.submitCartBillingForm = function ()
     *   {
     *       $('#collapseTwo').slideToggle('200', 'linear');
     *       $('#collapseFour').fadeIn();
     *   }
     *   codnitive.formValidate('#checkout_form', '.billing-submit', 'submitCartBillingForm');
     */
    formValidate: function(form, submit, callback)
    {
        $(document).ready(function () {
            $(form).validate();
            $('body').on('click', submit, function () {
                if ($(form).valid() && callback !== undefined) {
                    codnitive[callback](form, submit);
                }
            });
        });
    },

    /**
     * includeEndDate must be 1 or 0 (1 means include end date itself to days count)
     */
    daysBetween: function(startDate, endDate, includeEndDate)
    {
        // includeEndDate = includeEndDate == undefined ? 1 : includeEndDate;
        includeEndDate = includeEndDate || 1;
        startDate = new Date(startDate);
        endDate   = new Date(endDate);
        var startUtcDate = Date.UTC(startDate.getFullYear(), startDate.getMonth(), startDate.getDate());
        var endUtcDate   = Date.UTC(endDate.getFullYear(), endDate.getMonth(), endDate.getDate());
        return (endUtcDate - startUtcDate) / 86400000 + includeEndDate;
    },

    clone: function(src)
    {
        return Object.assign({}, src);
    },

    /**
     * push will add state to history so back button returns you to previous state 
     * but replace will replace current history state with new state and it will 
     * not add to history so back button returns you to previous address in histroy
     * 
     * @address     string          new url withour main domain (address after domain /)
     * @stateData   string|object   data you want pass to new page
     * @title       string          new state title (not required currently ff ignoring it)
     */
    historyState: function(stateData, title)
    {
        this.fullAddress = false;

        this.location    = codnitive.clone(document.location);
        this.stateData   = stateData || {};
        this.title       = title     || '';

        this.setStateData = function(stateData)
        {
            this.stateData = stateData || {};
            return this;
        };

        this.setTitle = function(title)
        {
            this.title = title || '';
            return this;
        };

        this.pushState = function(address)
        {
            window.history.pushState(this.stateData, this.title, address);
            return this;
        };

        this.replaceState = function(address)
        {
            window.history.replaceState(this.stateData, this.title, address);
            return this;
        };

        this.change = function(type)
        {
            type = type || 'push';
            var address = this.toString();
            return type == 'replace' 
                ? this.replaceState(address)
                : this.pushState(address);
        };

        this.changePath = function(path, type)
        {
            path = path.replace('/', '');
            this.location.pathname = '/' + path;
            return this.change(type);
        };

        this.pushPath = function(path)
        {
            return this.changePath(path, 'push');
        };

        this.replacePath = function(path)
        {
            return this.changePath(path, 'replace');
        };

        this.changeSearch = function(search, type)
        {
            search = search.replace('?', '');
            this.location.search = '?' + search;
            return this.change(type);
        };

        this.pushSearch = function(search)
        {
            return this.changeSearch(search, 'push');
        };

        this.replaceSearch = function(search)
        {
            return this.changeSearch(search, 'replace');
        };

        this.changeHash = function(hash, type)
        {
            hash = hash.replace('#', '');
            this.location.hash = '#' + hash;
            return this.change(type);
        };

        this.pushHash = function(hash)
        {
            return this.changeHash(hash, 'push');
        };

        this.replaceHash = function(hash)
        {
            return this.changeHash(hash, 'replace');
        };

        this.getHash = function()
        {
            return document.location.hash;
        };

        this.toString = function()
        {
            var location = this.location;
            var address  = this.fullAddress ? location.origin : '';
            return address + location.pathname + location.search + location.hash;
        };
    },

    rangePicker: function (selector, endValue, startValue, step)
    {
        this.selector   = selector;
        this.endValue   = endValue;
        this.startValue = startValue || 0;
        this.step       = step || 1000;

        this.init = function(selector, endValue, startValue, step, formatHour)
        {
            var rangePicker = this;
            rangePicker.selector   = selector;
            rangePicker.endValue   = endValue;
            rangePicker.startValue = startValue || 0;
            rangePicker.step       = step || 1000;
            rangePicker.minField   = selector + ' ~ .min-field';
            rangePicker.maxField   = selector + ' ~ .max-field';
            formatHour = formatHour || false;

            $(this.selector).slider({
                // tooltip_split: true,
                range: true,
                orientation: "horizontal",
                min: rangePicker.startValue,
                max: rangePicker.endValue,
                values: [rangePicker.startValue, rangePicker.endValue],
                step: rangePicker.step,
              
                slide: function (event, ui) {
                  if (ui.values[0] == ui.values[1]) {
                    return false;
                  }
                //   $('#double_number_range .ui-slider-range + span').text(ui.values[0]);
                //   $('#double_number_range span:last-child').text(ui.values[1]);
                  if ($(rangePicker.minField).length) {
                      var minVal = formatHour ? codnitive.formatHour(ui.values[0]) : ui.values[0];
                    $(rangePicker.minField).val(minVal);
                  }
                  if ($(rangePicker.maxField).length) {
                    var maxVal = formatHour ? codnitive.formatHour(ui.values[1]) : ui.values[1];
                    $(rangePicker.maxField).val(maxVal);
                  }
                }
            });
            rangePicker.updateSliderOnFieldChange();
        };

        this.updateSliderOnFieldChange = function()
        {
            var rangePicker = this;
            var min = rangePicker.minField;
            var max = rangePicker.maxField;
            $(min + ', ' + max).on("paste keyup", function () {
                var min_range = parseInt($(min).val());
                var max_range = parseInt($(max).val());

                if(min_range == max_range){
                      max_range = min_range + this.step;
                      $(min).val(min_range);		
                      $(max).val(max_range);
                }
        
                $(rangePicker.selector).slider({
                  values: [min_range, max_range]
                });
            });

            $(min + ', ' + max).on('change', function () {
                var min_range = parseInt($(min).val());
                var max_range = parseInt($(max).val());
        
                if (min_range > max_range) {
                    $(max).val(min_range);
                }
        
                $(rangePicker.selector).slider({
                    values: [min_range, max_range]
                });
                
            });
        }
    },

    // @link https://isotope.metafizzy.co/
    // @link https://codepen.io/lifeonlars/pen/yaaOZy
    // @usefule https://codepen.io/desandro/pen/owAyG/
    isotope: function ()
    {
        // Create object to store filter for each group
        this.filters = {};
        this.buttonFilter  = '*';
        this.rangeFilters  = {};

        this.init = function(itemsWrapper, sortData, itemSelector)
        {
            this.itemsWrapper = itemsWrapper;
            this.itemSelector = itemSelector || '.element-item';
    
            var grid = $(this.itemsWrapper).isotope({
                itemSelector: this.itemSelector,
                getSortData: sortData,
                layoutMode: 'vertical',
                // disable scale transform transition when hiding
                // hiddenStyle: {
                //     opacity: 0
                // },
                // visibleStyle: {
                //     opacity: 1
                // },
                transitionDuration: 0,
                // stagger: 30,
                // animationEngine: 'css',
                vertical: {
                    horizontalAlignment: 0.5,
                },
                /*getSortData: {
                    price: '[data-price] parseFloat',
                    departing: '[data-departing] parseInt',
                    // price:   '.final-price-filter',
                    // price: function(itemElem) {
                    //     return parseFloat($(itemElem).attr('data-price'));
                    // },
                    // departing: function(itemElem) {
                    //     return parseInt($(itemElem).attr('data-departing'));
                    // },
                }*/
            });
            grid.trigger('isotope:init');
            grid.on('isotope:sort isotope:filterCheckbox isotope:filterRange', function () {
                setTimeout(function () {
                    $('.list.results .overlay').addClass('hide');
                }, 150);
            });
            return grid;
        },

        // @link https://codepen.io/lifeonlars/pen/yaaOZy
        this.initFilter = function (grid)
        {
            var isotopeObj = this;
            grid.isotope({
                filter: function() {
                    var $this = $(this);

                    var isInRange = true;
                    for (var prop in isotopeObj.rangeFilters) {
                        if (prop.match('default')) {
                            continue;
                        }
                        var value = $this.attr('data-'+prop);
                        isInRange = isInRange && (isotopeObj.rangeFilters[prop].min <= value && isotopeObj.rangeFilters[prop].max >= value);
                    }
                    return $this.is(isotopeObj.buttonFilter) && isInRange;
                }
            });
            grid.trigger('isotope:initFilter');
            return grid;
        },

        this.initFilterMultiInstance = function (grid)
        {
            var isotopeObj = this;
            grid.isotope({
                filter: function() {
                    var $this = $(this);

                    var isInRange = true;
                    for (var prop in grid.rangeFilters) {
                        if (prop.match('default')) {
                            continue;
                        }
                        var value = $this.attr('data-'+prop);
                        isInRange = isInRange && (grid.rangeFilters[prop].min <= value && grid.rangeFilters[prop].max >= value);
                    }
                    return $this.is(isotopeObj.buttonFilter) && isInRange;
                }
            });
            grid.trigger('isotope:initFilter');
            return grid;
        },

        // bind sort button click
        this.sort = function(grid, sortButtonsGroup, sortButtons)
        {
            sortButtonsGroup = sortButtonsGroup || '.sort-button-group';
            sortButtons = sortButtons || 'button.sort-btn';

            $(sortButtonsGroup).on('click', sortButtons, function() {
                $('.list.results .overlay').removeClass('hide');
                /* Get the element name to sort */
                var sortBy = $(this).attr('data-sort-by');

                var isAscending = true;
                var newDirection = 'asc';
                if (sortBy !== 'original-order') {
                    /* Get the sorting direction: asc||desc */
                    var direction = $(this).attr('data-sort-direction');

                    /* convert it to a boolean */
                    var isAscending = direction == 'asc';
                    var newDirection = isAscending ? 'desc' : 'asc';
                }

                /* pass it to isotope */
                grid.isotope({sortBy: sortBy, sortAscending: isAscending});
                $(this).attr('data-sort-direction', newDirection);
                grid.trigger('isotope:sort');
            });
        },

        this.filterCheckbox = function (grid, filterButtonsGroup, filterButtons)
        {
            var isotopeObj = this;
            filterButtons = filterButtons || 'input[type=checkbox]';

            $(filterButtonsGroup).on('click', filterButtons, function () {
                $('.list.results .overlay').removeClass('hide');
                /*var filterValue = $(this).attr('data-filter');
                isotopeObj.isotope({filter: filterValue});*/
                
                var button = $(this);
                // get group key
                var buttonsGroup = button.parents('.filter-group');
                var filterGroup  = buttonsGroup.attr('data-filter-group');
                var filters      = isotopeObj.filters;
                // set filter for group
                if (filters[filterGroup] === undefined || filters[filterGroup].length == 0) {
                    filters[filterGroup] = [];
                }
                var filterOption = button.attr('data-filter');
                if (filters[filterGroup].includes(filterOption)) {
                    filters[filterGroup] = codnitive.removeArrayElement(filters[filterGroup], filterOption);
                }
                else {
                    filters[filterGroup].push(filterOption);
                }
                
                isotopeObj.filters = filters;
                // combine filters
                isotopeObj.buttonFilter = codnitive.concatArrayValues(filters) || '*';
                grid.isotope();
                bilit.updateSearchResultCount(grid.data('isotope').filteredItems.length);

                
                // combine filters
                // var filterValue = codnitive.concatArrayValues(filters);
                // grid.isotope({
                //     filter: filterValue
                // });
                grid.trigger('isotope:filterCheckbox');
            });
        },

        this.filterRange = function (grid, filterSliderGroup)
        {
            isotopeObj = this;
            $(filterSliderGroup).on('slidechange', function (event, ui) {
                $('.list.results .overlay').removeClass('hide');
                var slider = $(this);

                var sldmin = parseFloat(ui.values[0]),
                    sldmax = parseFloat(ui.values[1]),
                    filterGroup = slider.attr('data-filter-group');

                var defaultRange = isotopeObj.rangeFilters[filterGroup+'_default'];
                isotopeObj.rangeFilters[filterGroup] = {
                    min: sldmin || defaultRange.min,
                    max: sldmax || defaultRange.max
                };
                // Trigger isotope again to refresh layout
                grid.isotope();
                bilit.updateSearchResultCount(grid.data('isotope').filteredItems.length);
                grid.trigger('isotope:filterRange');
            });
        },

        this.filterRangeMultiInstance = function (grid, filterSliderGroup)
        {
            isotopeObj = this;
            $(filterSliderGroup).on('slidechange', function (event, ui) {
                $('.list.results .overlay').removeClass('hide');
                var slider = $(this);

                var sldmin = parseFloat(ui.values[0]),
                    sldmax = parseFloat(ui.values[1]),
                    filterGroup = slider.attr('data-filter-group');

                var defaultRange = grid.rangeFilters[filterGroup+'_default'];
                grid.rangeFilters[filterGroup] = {
                    min: sldmin || defaultRange.min,
                    max: sldmax || defaultRange.max
                };
                // Trigger isotope again to refresh layout
                grid.isotope();
                bilit.updateSearchResultCount(grid.data('isotope').filteredItems.length);
                grid.trigger('isotope:filterRange');
            });
        }
    },

    removeArrayElement: function (array, element)
    {
        var newArray = array.filter(function(item) { 
            return item !== element;
        })
        return newArray;
    },

    // flatten object by concatting values
    concatArrayValues: function(obj) 
    {
        var value = '';
        for (var prop in obj) {
            value += obj[prop].join(',');
        }
        return value;
    },
    
    showLoading: function(section, loading, customClass)
    {
        customClass = customClass || '';
        loading  = loading || '<i class="fa fa-spinner rotating"></i>Loading...';
        var html = '<div class="loading ' + customClass + '"><div class="message">' + loading + '</div></div>';
        $(section).append(html);
    },

    isEmptyElement: function (element)
    {
        return codnitive.isEmpty(element.html());
        // return $.trim(element.html()) == '';
    },

    isEmpty: function (value)
    {
        value = $.trim(value);
        return value == '' || !value;
    },

    formatHour: function (number)
    {
        return codnitive.pad(number.format(2, 2, '', ':'), 5);
    },

    pad: function (number, size)
    { 
        return ('000000000' + number).substr(-size); 
    },

    qtyPlus: function ()
    {
        $('body').on('click', '.simple-qty-control .qtyplus', function(e) {
            // Stop acting like a button
            e.preventDefault();
            var btn = $(this);
            var qtyField = $('input[name="' + btn.attr('data-qty-field') + '"]');
            var currentVal = parseInt(qtyField.val());
            var max = parseInt(btn.attr('data-max'));
            if (!isNaN(currentVal) && (isNaN(max) || currentVal < max)) {
                qtyField.val(currentVal + 1);
                btn.parents('.simple-qty-control').find('.qtyminus').attr("disabled", false);
            } 
            // else {
            //     qtyField.val(0);
            // }
            if (!isNaN(max) && parseInt(qtyField.val()) >= max) {
                btn.attr("disabled", true);
            }
            qtyField.trigger('change');
        });
    },

    qtyMinus: function ()
    {
        $('body').on('click', '.simple-qty-control .qtyminus', function(e) {
            // Stop acting like a button
            e.preventDefault();
            var btn = $(this);
            var qtyField = $('input[name="' + btn.attr('data-qty-field') + '"]');
            var currentVal = parseInt(qtyField.val());
            var min = parseInt(btn.attr('data-min')) || 0;
            if (!isNaN(currentVal) && (isNaN(min) || currentVal > min)) {
                qtyField.val(currentVal - 1);
                btn.parents('.simple-qty-control').find('.qtyplus').attr("disabled", false);
            } 
            // else {
            //     qtyField.val(0);
            // }
            if (!isNaN(min) && parseInt(qtyField.val()) <= min) {
                btn.attr("disabled", true);
            }
            qtyField.trigger('change');
        });
    },

    fieldQtyChangeButtonsListener: function ()
    {
        this.qtyPlus();
        this.qtyMinus();
    },

    dorpdown: function ()
    {
        $('body').on('click', '.dropdown-button', function () {
            $($(this).attr('data-dropdown-content')).toggle()
        })
    },

    formatRial: function(price, withSymbol)
    {
        withSymbol = withSymbol == undefined ? true : withSymbol;
        var formattedPrice = parseFloat(price).format(0, 3, ',', '.');
        if (withSymbol) {
            formattedPrice  += 'ریال';
        }
        return formattedPrice;
    },

    formDataAsJson: function ($form)
    {
        // https://stackoverflow.com/a/22420377/1227224
        var o = {};
        // var a = $($form).serializeArray();
        var a = codnitive.formDataSerializedArray($form);
        $.each(a, function() {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    },

    formDataSerialized: function ($form)
    {
        return $($form).serialize();
    },

    formDataSerializedArray: function ($form)
    {
        return $($form).serializeArray();
    },

    isWindowMinWidth: function (width)
    {
        var windowWidth = $(window).width();
        return windowWidth > width;
    },

    isWindowMaxWidth: function (width)
    {
        var windowWidth = $(window).width();
        return windowWidth < width;
    },
    
    togglePassworkVisibilite: function (passwordElement, buttonSelector) 
    {
        $('body').on('click', buttonSelector, function () {
            var toggleBtn = $(this);
            toggleBtn.toggleClass('fas fa-eye');
            toggleBtn.toggleClass('fas fa-eye-slash');
            passwordElement = $(passwordElement);
            passwordElement.prop('type', passwordElement.prop('type') === 'password' ? 'text' : 'password');
        });
    },

    disableButton: function (buttonElementSelector)
    {
        $('body').on('click', buttonElementSelector, function () {
            $(this).prop('disabled', true);
        });
    },

    disableFormSubmitByEnterKey: function (formSelector) 
    {
        $(document).on('keyup keypress', formSelector, function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                return false;
            }
        });
    },

    selectAllCheckboxes: function(checkAllSelector, itemsSelector, wrapperSelector)
    {
        checkAllSelector = checkAllSelector || '.select_all';
        itemsSelector = itemsSelector || '.item-checkbox';
        wrapperSelector = wrapperSelector || 'table';
        $('body').on('click', checkAllSelector, function() {
            let selectAll = $(this);
            selectAll.parents(wrapperSelector).find(itemsSelector).each(function() {
                $(this).prop('checked', selectAll.prop('checked'));
            });
        });
        $('body').on('click', `${wrapperSelector} ${itemsSelector}`, function () {
            let wrapper = $(this).parents(wrapperSelector);
            let itemsCount = wrapper.find(itemsSelector).length;
            let selectedItemsCount = wrapper.find(`${itemsSelector}:checked`).length;
            if (selectedItemsCount > 0 && itemsCount === selectedItemsCount) {
                wrapper.find(checkAllSelector).prop('checked', true);
            }
            else {
                wrapper.find(checkAllSelector).prop('checked', false);
            }
        });
    }
}

/**
 * Number.prototype.format(n, x, s, c)
 * 
 * @param integer n: length of decimal
 * @param integer x: length of whole part
 * @param mixed   s: sections delimiter
 * @param mixed   c: decimal delimiter
 */
Number.prototype.format = function(n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};
String.prototype.rtrim = function (s) {
    if (s == undefined)
        s = '\\s';
    return this.replace(new RegExp("[" + s + "]*$"), '');
};
String.prototype.ltrim = function (s) {
    if (s == undefined)
        s = '\\s';
    return this.replace(new RegExp("^[" + s + "]*"), '');
};
String.prototype.toEnglishDigits = function () {
    return this.replace(/[۰-۹]/g, function (chr) {
        var persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        return persian.indexOf(chr);
    });
};

// https://stackoverflow.com/a/22420377/1227224
$.fn.serializeObject = function() {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

// $(document).ready(function () {
//     codnitive.addFieldSet('#speaker-form-base');
// });
// })(jQuery);
