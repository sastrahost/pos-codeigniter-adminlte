/**
 * Version: 0.3
 * Updated: 2016-01-06
 *
 * jQuery plugin for modal Font Awesome spin loading icons
 *
 * Copyright (c) 2015 Alê Monteiro (contato@alemonteiro.com.br, https://github.com/alemonteiro/jquery-fa-loading)
 *
 * Licensed under the MIT (LICENSE.txt)
 **/

/**
 * Requirements:
 * - jQuery (John Resig - http://www.jquery.com/)
 * - Font Awesome (davegandy - http://fontawesome.io)
 **/

(function($){

    var _hasText = function(txt) {
        if (txt === undefined || txt === null || txt === false || $.trim(txt).replace(/ /gi, '') === "") {
            return false;
        }
        return true;
    };

    $.faLoadingDefaultIcon = 'fa-refresh';

    $.fn.extend({

        // Creates the loading and return the last object set
        faLoading: function (loadType, icon, status, spin, message, title, timeout, closeCallBack, closeButton) {

            var _defaults = {
                type: undefined // undefined or true will add loading other can be "add", "remove" or "update"
                , title: undefined // creates an title bar
                , icon: "fa-refresh" //  fa icon
                , spin: true // icon sppining
                , status : "loading" // text message ( undefined or false for empty )
                , text : false   // text message ( undefined or false for empty )
                , timeout : undefined // timeout to close msg
                , closeCallback: undefined // call back for when the message is closed (by timeout or x button(in case it ever gets one))
                , closeButton: false // adds and close button
            };

            if (loadType === "fail") {
                return $(this).faLoading({
                    type: "update",
                    icon: "fa-exclamation-triangle",
                    spin: false,
                    status: "fail",
                    text: icon,
                    title: status,
                    timeout: spin !== undefined ? spin : 6000,
                    closeButton: true
                });
            }
            else if (loadType === "success") {
                return $(this).faLoading({
                    type: "update",
                    icon: "fa-check-circle",
                    spin: false,
                    status: "success",
                    text: icon,
                    title: status,
                    timeout:  spin !== undefined ? spin : 6000,
                    closeButton: true
                });
            }
            else if (loadType === "remove" || loadType === false) {
                return $(this).each(function() {
                    $(this)
                        .removeClass("jq-fa-loading has-text icon-only")
                        .removeClass($(this).data('fa-loading-status'))
                        .find('div.fa-loading-wrapper').remove();
                });
            }
            else if ( loadType === "update" && icon !== undefined ) {
                return $(this).each(function() {
                    var $t = $(this).hasClass("jq-fa-loading") ? $(this) : $(this).first(".jq-fa-loading");

                    if ( ! $t.hasClass("jq-fa-loading") ) {
                        return $(this).faLoading({
                            type: "add",
                            icon: icon,
                            spin: spin,
                            status: status,
                            text: message,
                            title: title,
                            closeButton: closeButton,
                            closeCallback: closeCallBack,
                            timeout: timeout
                        });
                    }
                    var	$w = $t.find('.fa-loading-wrapper'),
                        $i = $t.find('i.fa-loading-icon'),
                        lastStatus = $t.data('fa-loading-status'),
                        lastIcon = $t.data('fa-loading-icon');

                    if ( spin === false && $i.hasClass('fa-spin') ) $i.removeClass('fa-spin');

                    $t
                        .find('.fa-loading-text')
                        .empty();
                    if ( message !== undefined && message !== false ) {
                        $t
                            .removeClass('icon-only')
                            .find('.fa-loading-text')
                            .html(message);
                    }
                    else if ( message === false ){
                        $t
                            .addClass('icon-only')
                            .find('.fa-loading-text')
                            .html('')
                    }
                    if ( title !== undefined && title !== false ) {
                        $t
                            .addClass('has-title')
                            .find('.fa-loading-header > label:eq(0)')
                            .html(title);
                    }
                    else if ( title === false ) {
                        $t
                            .removeClass('has-title')
                            .find('.fa-loading-header > label:eq(0)')
                            .html(title);
                    }
                    $t.data('fa-loading-icon', icon);
                    $i.removeClass(lastIcon).addClass(icon);

                    if ( closeButton !== true && $w.find(".fa-loading-close").length < 1 ) {
                        $w.find('.fa-loading-header')
                            .append('<span class="fa fa-close fa-loading-close"></span>')
                            .on('click', 'span.fa-loading-close', function() {
                                $t.faLoading('remove');
                            });
                    }

                    if ( timeout !== undefined && timeout > 0 ) {
                        setTimeout(function() {
                            //alert('removed timeout');
                            $t.faLoading("remove");
                        }, timeout > 60 ? timeout : timeout * 1000);
                    }

                    if (status !== undefined && typeof status === 'string' ) {
                        if ( typeof $.switchClass === 'function') {
                            $t.switchClass(lastStatus, status, 800);
                        }
                        else {
                            $t.removeClass(lastStatus).addClass(status);
                        }
                        //if ( lastStatus !== undefined && typeof lastStatus === 'string') {
                        //$t.removeClass(lastStatus);
                        //}
                        //$t.addClass(status);
                        $t.data('fa-loading-status', status);
                    }

                });
            }
            else if (typeof loadType === 'object' && arguments.length == 1) {
                var opts = $.extend({}, _defaults, loadType);

                return $(this).faLoading(opts.type, opts.icon, opts.status, opts.spin, opts.text, opts.title, opts.timeout, opts.closeCallback, opts.closeButton);
            }

            if ( loadType === undefined || loadType.indexOf("fa-") == -1 || loadType === "add") {
                if ( icon === undefined || icon.toString().length < 1 ) {
                    loadType = $.faLoadingDefaultIcon || 'fa-refresh';
                }
                else {
                    loadType = icon;
                }
                if ( status === undefined ) status = 'loading';
            }
            if ( status === undefined || status === null || $.trim(status.toString()).length < 1  ) {
                status = 'loading';
            }
            if ( $(this).hasClass("jq-fa-loading") && status === 'loading' ) {
                return $(this).faLoading(false);
            }
            // Adds Loading

            return $(this).each(function() {
                var $t = $(this);
                $t
                    .removeClass('jq-fa-loading loading has-title icon-only ')
                    .addClass("jq-fa-loading " + status +
                        (_hasText(title) ? ' has-title' : '') +
                        (_hasText(message) ? '' : ' icon-only')
                    )
                    .data('fa-loading-status', status)
                    .data('fa-loading-icon', loadType);
                $('<div class="fa-loading-wrapper">'+
                    '<div class="fa-loading-modal">&nbsp;</div>'+
                    '<div class="fa-loading-content-wrapper">' +
                    '<div class="fa-loading-content">' +
                    '<div class="fa-loading-header">' +
                    '<label>' +
                    (typeof title === 'string' ? title : '') +
                    '</label>' +
                    '</div>' +
                    '<div class="fa-loading-body">' +
                    '<p>' +
                    '<i class="fa '+loadType+ (spin !== false ? ' fa-spin' : '') + ' fa-loading-icon"></i>'+
                    '<span class="fa-loading-text">' +
                    (typeof message === 'string' ? message : '') +
                    '</span>' +
                    '</p>' +
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>').appendTo($t);
                if ( $t.is('body') ) {
                    $t
                        .children('div.fa-loading-wrapper')
                        .children('div.fa-loading-modal')
                        .css("position", "fixed")
                        .next('div').css("position", "fixed");
                }
                if ( closeButton === true && $t.find(".fa-loading-close").length < 1 ) {
                    $t.find('.fa-loading-header')
                        .append('<span class="fa fa-close fa-loading-close"></span>')
                        .on('click', 'span.fa-loading-close', function() {
                            $t.faLoading('remove');
                        });
                }
                if ( timeout !== undefined && timeout !== false && timeout > 0 ) {
                    setTimeout(function() {
                        $t.faLoading("remove");
                    }, timeout > 60 ? timeout : timeout * 1000);
                }
                return $t;
            });
        }
    });

}(jQuery)); 