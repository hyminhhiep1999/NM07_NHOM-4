// PHAN TRANG
// Số sản phẩm mỗi trang
const perPage = 2;
// Số trang hiện tại
let currentPage = 1;
// Nút load more
const btnLoad = document.querySelector('#btn-loadmore');
const result = document.getElementById('result');
btnLoad.addEventListener('click', function () {
    loadMore();
})

async function loadMore() {
    btnLoad.textContent = "Loading..."; // Khi đang load thì button hiện Loading
    currentPage++;
    // url sẽ xử lý phía server
    const url = 'getItemByCategory.php';

    console.log(currentPage);
    // Chuyển data nhận vào thành kiểu Object để parse sang JSON
    const data = {categoriesChecked: categoriesChecked, currentPage: currentPage, perPage: perPage};

    // Gửi request
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    });

    // chuyển dữ liệu trả về theo kiểu JSON
    const products = await response.json();
    
    // Khai báo Html sẽ được render

    // Nếu không có phần tử dư => là trang cuối cùng thì disable button
    if (!products[perPage]) {
        btnLoad.textContent = "Nothing more";
        btnLoad.classList.add("disabled");
        btnLoad.setAttribute("disabled", "disabled");
        currentPage = -1; // là trang cuối cùng, không còn gì để load
    }

    // Chỉ hiện <= perPage (perPage ở đây là 2) phần tử
    if(products.length === perPage + 1)
        products.length = perPage;


    products.forEach(item => {
        const pName = encodeURIComponent(item.product_name.toLowerCase().trim());
        const rowEl = document.createElement('div');
        rowEl.classList.add('row');
        rowEl.innerHTML = `
            <div class="row">
                <div class="col-md-2">
                    <img src="./public/images/${item['product_image']}" alt="" class="img-fluid" onclick="getProduct(${item['product_id']})">
                </div>
                <div class="col-md-10">
                    <h4><a href="./product.php/${pName + '-' + item['product_id']}">${item['product_name']}</a></h4>
                    <p>${item['product_price']}</p>
                </div>
            </div>`;

        // Đẩy html được render vào
        result.appendChild(rowEl);
    })

    // Nếu còn thì hiện Load More không thì sẽ là Nothing More ở trên
    if (currentPage != -1)
        btnLoad.textContent = "Load More";
}


//CATEGORY FILTER
// Khai báo mảng chứa các value "được check"
const categoriesChecked = [];
    
// Lấy các checkbox có trong trang
const checkboxes = document.querySelectorAll(`input[type="checkbox"]`);

// Add event cho các checkbox
checkboxes.forEach(checkbox => checkbox.addEventListener('change', function() {
    // Được check thì đẩy vào mảng else Xóa ra khỏi mảng
    if (this.checked) {
        categoriesChecked.push(+this.value);
    } else {
        // Nếu uncheck thì bỏ phần tử đó ra khỏi mảng category được chọn
        const index = categoriesChecked.indexOf(+this.value);
        if (index !== -1) categoriesChecked.splice(index, 1);
    }

    // Sort để lúc nào lấy cũng trả về mảng dữ liệu đồng bộ
    categoriesChecked.sort();
    getProduct(categoriesChecked); // Gọi hàm xử lý
}));

async function getProduct(categoriesChecked) {
    // Reset lại số trang và button

        btnLoad.textContent = "Load more";
        btnLoad.classList.remove("disabled");
        btnLoad.removeAttribute("disabled");
    
    currentPage = 1

    
    // url sẽ xử lý phía server
    const url = 'getItemByCategory.php';

    // Chuyển data nhận vào thành kiểu Object để parse sang JSON
    const data = {categoriesChecked: categoriesChecked};

    // Gửi request
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    });

    // chuyển dữ liệu trả về theo kiểu JSON
    const products = await response.json();

    // Khai báo Html sẽ được render
    let productsResult = ""; // clear
    // Khai báo Html sẽ được render
    if(products.length === perPage + 1)
        products.length = perPage;

    products.forEach(item => {
        const pName = encodeURIComponent(item.product_name.toLowerCase().trim());
        productsResult += `
            <div class="row">
                <div class="col-md-2">
                    <img src="./public/images/${item['product_image']}" alt="" class="img-fluid" onclick="getProduct(${item['product_id']})">
                </div>
                <div class="col-md-10">
                    <h4><a href="./product.php/${pName + '-' + item['product_id']}">${item['product_name']}</a></h4>
                    <p>${item['product_price']}</p>
                </div>
            </div>`;
    })
    
    // Đẩy html được render vào
    result.innerHTML = productsResult;
}
// Lấy sản phẩm lần đầu khi mới load trang
getProduct(categoriesChecked);
