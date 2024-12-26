const topBarSlider = document.getElementById('top-bar-slider');
const testominalSlider = document.getElementById('testominal');

if (topBarSlider) {
    var slider = tns({
        container: '.top-blog-slider',
        items: 1,
        autoplay: true,
        controls: false,
        nav: false,
        autoplayButtonOutput: false,
        speed: 8000,
        autoplayTimeout: 4100,
        autoplayHoverPause: true,
        responsive: {
            0: {
                edgePadding: 20,
                gutter: 20,
                items: 1
            },
            
            500: {
                items: 2
            },
            990: {
                items: 3
            },
            // 1100:{
            //     items: 4
            // },
            1800: {
                items: 5
            }
        }
    });
}


if (testominalSlider) {
    var slider = tns({
        container: '.testominal-slider',
        items: 3,
        // gutter: 20,
        // edgePadding: 30,
        mouseDrag: true,
        autoplay: true,
        controls: false,
        controlsText: ['<i class="fas">&#xf104;</i>', '<i class="fas">&#xf105;</i>'],
        nav: true,
        navPosition: "bottom",
        arrowKeys: true,
        autoplayButtonOutput: false,
        autoplayTimeout: 4100,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            
            500: {
                items: 2
            },
            900: {
                items: 3
            },
        }
    });
}

