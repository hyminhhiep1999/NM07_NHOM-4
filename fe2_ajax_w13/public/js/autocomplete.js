const searchResult = document.querySelector('#search-result');
const searchInput = document.querySelector('#q');

searchInput.addEventListener('keyup', function () {
    const keyword = encodeURIComponent(this.value);
    if (keyword === '') {
        searchResult.innerHTML = '';
    }
    else
    autoComplete(keyword);
});

async function autoComplete(keyword) {
    // url sẽ xử lý phía server
    const url = `search.php?q=${keyword}`;

    // Gửi request
    const response = await fetch(url);

    // chuyển dữ liệu trả về theo kiểu JSON
    const products = await response.json();

    // Khai báo Html sẽ được render
    let results = ""; // clear

    products.forEach(item => {
        const pURI = encodeURIComponent(item.product_name.toLowerCase().trim());
        const kRegex = new RegExp('(' + decodeURIComponent(keyword) + ')', 'gi');
        const pName = item.product_name.replace(kRegex, `<span class="hightlight">$1</span>`)
        results += `<li><a href="./product.php/${pURI}-${item.product_id}">${pName}</a></li>`;
    })

    // Đẩy html được render vào
    searchResult.innerHTML = results;
}