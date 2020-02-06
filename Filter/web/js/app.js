var slider = document.getElementById('price-slider');

if (slider) {

    var minPrice = Math.floor(parseInt(slider.dataset.min, 10) / 10) * 10;
    var maxPrice = Math.ceil(parseInt(slider.dataset.max, 10) / 10) * 10;

    var minInput = document.getElementById('min');
    var maxInput = document.getElementById('max');

    var range = noUiSlider.create(slider, {
        start: [minInput.value || minPrice, maxInput.value || maxPrice],
        connect: true,
        step: 10,
        range: {
            'min': minPrice,
            'max': maxPrice
        }
    });

    range.on('slide', function (values, handle) {
        if (handle === 0) {
            minInput.value = Math.round(values[0]);
        }
        if (handle === 1) {
            maxInput.value = Math.round(values[1]);
        }
    });

}
