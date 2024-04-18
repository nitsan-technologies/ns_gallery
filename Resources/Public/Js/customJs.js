$(document).ready(function () {
    var wall = [];
    $('.lg-outer .lg-thumb-open .lg-sub-html').remove();
    $('.loaderImage').show();
// main image loaded ?
    $('.ns-gallery-slide .ns-gallery-item img').on('load', function(){
        // hide/remove the loading image
        $('.loaderImage').hide();
    });

    if ($('.ns-gallery-google-view').length) {
        $('.GITheWall').each(function(index, item) {
            var initialHeight = 500;
            wall[index] = $(this).GITheWall({
                nextButtonClass: 'nsgallery-icon nsgallery-next-icon',
                prevButtonClass: 'nsgallery-icon nsgallery-prev-icon',
                closeButtonClass: 'nsgallery-icon nsgallery-close-icon',
                initialWrapperHeight: initialHeight
            });
        });
    }
    var paginationType = $('#paginationType').val();
    themeClass = 'ns-gallery-arrow--icon-circle video-not-supported';
    function getTotPage($totalPage, $perPage){
        var totPages2 = Math.ceil($totalPage / $perPage);
        return totPages2;
    }

    $('#cover-spin').hide();

    $(document).on('click', '.article-load-more', function (e) {
        if (paginationType == 'pagination') {
            var getParentID = $(this).parent().parent().parent().parent().attr('id');
        } else {
            var getParentID = $(this).parent().parent().attr('id');
        }

        var totNews = $('#totNews-' + getParentID).val();
        var perPage = $('#perPage-' + getParentID).val();
        var totPages = getTotPage(totNews, perPage);

        if (checkCurrentGallery.includes(getParentID)) {
            var galleryPage = checkCurrentGallery[getParentID][0];
            checkCurrentGallery[getParentID]= [galleryPage+1];
            curPage = galleryPage+1;
        } else {
            curPage = 1;
            checkCurrentGallery.push(getParentID);
            checkCurrentGallery[getParentID] = [];
            checkCurrentGallery[getParentID].push(curPage);
        }

        e.preventDefault();
        $('#cover-spin').show();
        curPage = curPage + 1;

        var curPageUrl = $(this).attr('href');
        var nextPageUrl = curPageUrl;

        var lastVid = $('#lastVid-'+ getParentID).val();
        $.ajax({
            type: 'GET',
            url: nextPageUrl,
            success: function (response) {
                if (paginationType == 'pagination') {
                    var findNextPageURL = $(response).find('#' + getParentID).find('.pagination-block').html();
                    $('#' + getParentID + ' .pagination-block').html(findNextPageURL);
                } else {
                    var findNextPageURL = $(response).find('.article-load-more').attr('href');
                    $('#' + getParentID + ' .article-load-more').attr('href', findNextPageURL);
                }
                var findNReplace = '#' + getParentID + ' .cus-row';

                var disdata = $(response).find(findNReplace).html();

                disdata = $(disdata + ' .ajaxBlock-'+getParentID).addClass('page-' + curPage);

                var lastVid2 = $(response).find('#lastVid-'+ getParentID).val();
                $('#lastVid-'+ getParentID).val(lastVid2);

                $(disdata).find('.grid-sizer .page-2').remove();

                if (paginationType == 'pagination') {
                    $('.cus-row .ajaxBlock-'+getParentID).remove();
                } else {
                    if (totPages === curPage || totPages == 0) {
                        $('#' + getParentID + ' .pagination-block .article-load-more').fadeOut();
                    }
                }

                $('.GITheWall').each(function(index, item) {
                    wall[index].refresh();
                });

                try {
                    $('.' + getParentID).data('lightGallery').destroy(true);
                } catch (ex) { };

                var gallerySettings = $('#gallery-settings-' + getParentID).val();
                if (gallerySettings) {
                    var getSettings = gallerySettings.split(',');
                    getSettings.forEach(settVal => {
                        var getKey = settVal.split(':');
                        switch (getKey[0]) {
                            case "controls":
                                $controls = getKey[1];
                                if ($controls == 'true' || $controls == 1) {
                                    $controls = true;
                                } else {
                                    $controls = false;
                                }
                                break;
                        }
                    });

                    //and then re-initiate gallery again
                    $('.' + getParentID).lightGallery({
                        selector: '.ns-gallery-item',
                        addClass: themeClass,
                        controls : $controls,
                        download:false,
                    });
                }
                $('#cover-spin').hide();
            }
        });
    });

});