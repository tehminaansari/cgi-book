/**
 * Cgi Book Module
 *
 * @category   Cgi
 * @package    Cgi_Book
 * @version    1.0.0
 * @description js file
 *
 * Release with version 1.0.0
 *
 *
 */
/*global window,requirejs,document*/
/*jslint eqeq: true*/
/*jslint unparam: true*/
require(
    [
    'jquery',
    'mage/url',
    'Cgi_Book/js/jquery.dataTables.min',
    'jquery/ui',
    'Magento_Ui/js/modal/confirm'
    ],
    function (
        $,
        url,
        dataTable,
        ui,
        confirm
    ) {
    'use strict';
    $(function () {
        $(document).ready(function () {
            window.bookTitle = "";
            window.datatableBook = $('#datatable-book').dataTable({
                "ordering": false,
                "lengthMenu": [10, 15, 20],
                'iDisplayLength': 10,
                "sPaginationType": "simple_numbers",
                "bProcessing": false,
                "bServerSide": true,
                "bSortable": false,
                "searching": true,
                "sAjaxSource": url.build('/cgimizon/book/listing'),
                "bDeferRender": true,
                "sDom": '<"top"lp><"clear">rt<"clear"><"bottom">',
                'fnServerData': function (sSource, aoData, fnCallback) {
                    $.ajax({
                        cache: false,
                        showLoader: true,
                        'dataType': 'json',
                        'type': 'GET',
                        'url': sSource,
                        'data': aoData,
                        'success': [
                            function (r) {
                                if (r.iTotalRecords <= window.datatableBook.fnSettings()._iDisplayLength) {
                                    $('#datatable-book_wrapper').find('.dataTables_paginate').hide();
                                } else {
                                    $('#datatable-book_wrapper').find('.dataTables_paginate').show();
                                }
                                fnCallback(r);
                            }
                        ]
                    });
                },
                createdRow: function (row, data, dataIndex) {
                    // Add COLSPAN attribute
                    $('td:eq(0)', row).attr('colspan', 2);
                    $('td:eq(0)', row).addClass('datatable_book');
                },
                "oLanguage": {
                    "sSearch": "",
                    "sLengthMenu": "<span class='lengthf'>Show</span> _MENU_ <span class='lengtht'>per page</span>",
                    "oPaginate": {
                        "sNext": "&#8594",
                        "sPrevious": "&#8592;"
                    },
                    "sEmptyTable": "No records found.",
                    "sZeroRecords": "No records found."
                },
                "fnServerParams": function (aoData) {
                    //ajax request fields extra
                    aoData.push({
                        "name": "bookTitle",
                        "value": window.bookTitle
                    }, {
                       "name": "pageNumber",
                       "value": $('#datatable-book').DataTable().page.info().page
                    });
                },
                "aoColumns": [
                    {"mDataProp": "cour_name"}
                ]
            });
            
            
        });
        $("#datatable-book").on('click', '.selectOption', function () {
            $(this).parent().parent().parent().parent().removeClass('borderbottom0');
        });
        
        $('.my-books').on('keyup', '#book-title', function (e) {
            if (e.keyCode == 13) { //Perforn search on datatable when user press enter button
                window.updateBookTitleFilter();
            }
        });
        $('.my-books').on('click', '#book-title-btn', function () {
            window.updateBookTitleFilter();
        });
        $('.my-books').on('click', '#book-title-clear-btn', function () {
            $('#book-title').val("");
            window.bookTitle = "";
            window.datatableBook.fnFilter(window.bookTitle);
            window.hideShowBookTitleClearIcon();
        });

    });
    
    window.updateBookTitleFilter = function () {
        $('#book-title').val($.trim($('#book-title').val()));
        window.bookTitle = $('#book-title').val();
        if (window.bookTitle != "") {
            window.hideShowBookTitleClearIcon();
            window.datatableBook.fnFilter(window.bookTitle);
        }
    };
    
    window.hideShowBookTitleClearIcon = function () {
        if ($('#book-title').val() != "") {
            $('#book-title-clear-btn').show();
        } else {
            $('#book-title-clear-btn').hide();
        }
    };
        
    }
);