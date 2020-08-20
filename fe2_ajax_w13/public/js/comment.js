const stars = [...document.getElementsByClassName("fa-star")];
const btnPost = document.getElementById("btnPost");
const commentArea = document.getElementById("commentArea");
let rate = 0;
let firstTime = true;

stars.map((star, index) =>
  star.addEventListener("click", function() {
    stars.forEach(star => star.classList.remove("rate"));

    let count = index;
    rate = index + 1;
    while (count >= 0) {
      stars[count--].classList.add("rate");
    }
  })
);

stars.map((star, index) =>
  star.addEventListener("mouseover", function() {
    stars.forEach(star => star.classList.remove("rate"));

    let count = index;
    rate = 0;
    while (count >= 0) {
      stars[count--].classList.add("rate");
    }
  })
);

stars.map(star =>
  star.addEventListener("mouseout", function() {
    if (!rate) stars.forEach(star => star.classList.remove("rate"));
  })
);

btnPost.addEventListener("click", postComment);

async function postComment() {
  // url sẽ xử lý phía server
  const url = `/${baseUrl}/comment.php`;

  // Chuyển data nhận vào thành kiểu Object để parse sang JSON
  const data = {
    productId: productId,
    commentContent: document.getElementById("validationTextarea").value,
    commentRate: rate,
    firstTime: firstTime
  };
  firstTime = false;

  // Gửi request
  const req = await fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json"
    },
    body: JSON.stringify(data)
  });

  // chuyển dữ liệu trả về theo kiểu JSON
  const comments = await req.json();

  commentArea.innerHTML = "";
  comments.forEach(comment => {
    const commentEl = document.createElement("li");

    for (let i = 1; i <= comment["comment_rate"]; i++) {
      commentEl.innerHTML +=
        '<i class="fa fa-star rate" aria-hidden="true"></i>';
    }
    for (let i = comment["comment_rate"] + 1; i <= 5; i++) {
      commentEl.innerHTML += '<i class="fa fa-star" aria-hidden="true"></i>';
    }
    commentEl.innerHTML += `<br /> ${comment["comment_content"]}`;

    // Đẩy html được render vào
    commentArea.appendChild(commentEl);
  });

  stars.forEach(star => star.classList.remove("rate"));
  document.getElementById("validationTextarea").value = "";
}

postComment();
