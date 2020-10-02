$ = jQuery;

let frmWrapper = $("#memo-ajax-course-filter-search");
let frmSearch = frmWrapper.find("form");

frmSearch.submit((event) => {
    event.preventDefault();

    console.log("Form Submitted");
    let searched_value = '';

    if (frmSearch.find("#search-input").val().length !== 0) {
        searched_value = frmSearch.find("#search-input").val();
    }

    const data = {
        action: 'memo_course_filter_search',
        s: searched_value
    };
    console.log(data);
    // debugger;
    console.log(ajax_url);

    $.ajax({
        url: ajax_url,
        data: data,
        method: 'GET',
        success: (res) => {
            $('#search_response_wrapper').empty();
            console.log(res);
            if (res) {
                let counter = 0;
                let html = '';
                for(let i =0; i < res.length; i++) {
                    counter++;
                    let classes = '';
                    if (counter < 3) {
                        classes = ' border-right';
                    }
                    html += '<div class="col-md-4 pt-3 pb-3' + classes + '">';
                    html += '<h2 class="title mb-5 muted">' + res[i].month + '</h2>';
                    html += '<h5 class="strong"><a href="' + res[i].permalink + '" class="underline">' + res[i].title + '</a></h5>';
        // $html .= sprintf( '<h5 class="strong"><a href="%s" class="underline">%s</a></h5>', esc_url( $permalink ), esc_html__( $title, 'cademy' ) );
        // $html .= sprintf( , esc_html( $start_date ) ); 
                    html += '<small>' + res[i].start_date + '</small>';
        // $html .= sprintf( '<h6 class=""><a href="#">%s</a></h6>', esc_html__( $post_category->name, 'cademy' ) ); 
                    html += '</div>';
                }
                $('#search_response_wrapper').append(html);
            } else {
                let html = "<p>No courses found. Try a different filter or search keyword.</p>";
                $('#search_response_wrapper').append(html);
            }
        },
        error : (error) => console.log(error)
    });


});