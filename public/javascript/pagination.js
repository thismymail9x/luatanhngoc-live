function EBE_part_page(Page, TotalPage, strLinkPager, sub_part) {
    if (TotalPage <= 1) {
        return '\u0110ang hi\u1ec3n th\u1ecb trang <span data-page="' + Page + '" class="current">' + Page + '</span> ';
    }
    if (typeof sub_part == 'undefined') {
        sub_part = '/page/';
    }
    strLinkPager += sub_part;
    var show_page = 8;
    var chia_doi = Math.ceil(show_page / 2);
    var current_page = ' <span data-page="' + Page + '" class="current">' + Page + '</span> ';
    Page *= 1;
    var prev_page = '';
    var first_page = '';
    var begin_i = Page - chia_doi;
    if (begin_i < 1) {
        begin_i = 1;
    } else if (begin_i > 1) {
        first_page = ' <a data-page="' + (Page - 1) + '" href="' + strLinkPager + (Page - 1) + '" rel="nofollow">&lt;&lt;</a> ';
        first_page += ' <a data-page="1" rel="nofollow" href="' + strLinkPager + '1">1</a> ';
        if (begin_i > 2) {
            first_page += ' ... ';
        }
    }
    for (var i = begin_i; i < Page; i++) {
        prev_page += ' <a data-page="' + i + '" rel="nofollow" href="' + strLinkPager + i + '">' + i + '</a> ';
        show_page--;
    }
    var next_page = '';
    var last_page = '';
    var end_i = Page + show_page;
    if (end_i > TotalPage) {
        end_i = TotalPage;
    } else if (end_i < TotalPage) {
        if (end_i < TotalPage - 1) {
            last_page += ' ... ';
        }
        last_page += ' <a data-page="' + TotalPage + '" rel="nofollow" href="' + strLinkPager + TotalPage + '">' + TotalPage + '</a> <a data-page="' + (Page + 1) + '" href="' + strLinkPager + (Page + 1) + '" rel="nofollow">&gt;&gt;</a> ';
    }
    for (var i = (Page + 1); i <= end_i; i++) {
        next_page += ' <a data-page="' + i + '" rel="nofollow" href="' + strLinkPager + i + '">' + i + '</a> ';
    }
    return first_page + prev_page + current_page + next_page + last_page;
}

$('.each-to-page-part').each(function () {
    var page = $(this).attr('data-page') || '';
    var total = $(this).attr('data-total') || '';
    var url = $(this).attr('data-url') || '';
    var params = $(this).attr('data-params') || '';
    $(this).before(EBE_part_page(page, total, url, params));
});
$('.each-to-page-part').before('<!-- div.each-to-page-part -->').remove();