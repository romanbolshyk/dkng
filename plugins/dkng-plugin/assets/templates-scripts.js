( function ( $, window, document, undefined ) {
    'use strict';

    const fltrForm = $( '#js_svTplFilter' );

    $( document ).ready( function () {

        // Load more posts button click
        $( 'body' ).on( 'click', '.tplLoadMore', function () {
            fltrForm.find( '[name="page"]' ).attr( 'value', $( this ).data( 'page' ) );
            loadMoreMCPosts();
            return false;
        } );

        // Form filter apply
        fltrForm.on( 'change', 'select', function () {
            fltrForm.find( '[name="page"]' ).attr( 'value', 1 );
            loadMoreMCPosts( true );
            return false;
        } );

    } );

    // load more posts + multy criteria filter
    function loadMoreMCPosts ( reload ) {
        let frame_button = $( '.buttonAjaxFrame' );
        let frame_content = $( '.htmlAjaxFrame' );

        $.ajax( {
            type: "POST",
            url: get.ajaxurl,
            data: fltrForm.serialize(),
            dataType: "json",
            beforeSend: function () {
                // frame_button.empty();
                // frame_button.addClass('loading');
            },
            success: function ( resp ) {
                if ( resp.html !== undefined ) {
                    if ( reload === true ) {
                        frame_content.html(resp.html.trim());
                        // frame_button.removeClass('loading');
                    }
                else {
                        frame_content.append(resp.html.trim());
                        // frame_button.removeClass('loading');
                    }
                    if (resp.html === '') {
                        frame_content.html('<div class="no_available">There no available template</div>');
                    }

                }
                if ( resp.button !== undefined ) {
                    frame_button.html( resp.button.trim() );
                }

                $( 'body' ).removeClass( 'processing' );
            },
        } );
        return false;
    }

    // open modal with asset preview
    $( '.template' ).on( 'click', '.btn-view', function ( e ) {
        e.preventDefault();
        var content = $( this ).closest( '.item' ).find( '.item-image' ).html();
        var btn = $( this ).closest( '.item' ).find( '.item-btn-wrap' ).html();
        $( '.template-modal' ).addClass( 'active' );
        $( '.template-modal-container' ).html( content  );
        $( '.template-modal-close-wrap' ).prepend( btn );
        $( '.template-modal-close-wrap .btn-view' ).remove();

        return false;
    } );

    // close the modal
    $( '.template, .search_page' ).on( 'click', '.template-modal-close', function ( e ) {
        e.preventDefault();
        $( '.template-modal' ).removeClass( 'active' );
        $( '.template-modal-container' ).html( '' );
        $( '.template-modal-close-wrap .btn' ).remove();
    } );

    // download the asset
    $( '.template, .search_page' ).on( 'click', '.btn-pdf-download', function ( e ) {
        e.preventDefault();
        var down = $( this ).attr( 'data-href' );
        DownloadFile( down )
    } );

    function DownloadFile ( fileName ) {
        //Set the File URL.
        var url = fileName;

        $.ajax( {
            url: url,
            cache: false,
            xhr: function () {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if ( xhr.readyState == 2 ) {
                        if ( xhr.status == 200 ) {
                            xhr.responseType = "blob";
                        } else {
                            xhr.responseType = "text";
                        }
                    }
                };
                return xhr;
            },
            success: function ( data ) {
                //Convert the Byte Data to BLOB object.
                var blob = new Blob( [ data ], {type: "application/octetstream"} );

                //Check the Browser type and download the File.
                var isIE = false || !!document.documentMode;
                if ( isIE ) {
                    window.navigator.msSaveBlob( blob, fileName );
                } else {
                    var url = window.URL || window.webkitURL;
                    link = url.createObjectURL( blob );
                    var a = $( "<a />" );
                    a.attr( "download", fileName );
                    a.attr( "href", link );
                    $( "body" ).append( a );
                    a[0].click();
                    $( "body" ).remove( a );
                }
            }
        } );
    }


} )( jQuery, window, document );