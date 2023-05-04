function copyClipboard(url) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(url).select();
    document.execCommand("copy");
    $temp.remove();

    document.getElementById("modalbree").innerHTML = `
        <div class="main-modal h-100 animated fadeIn faster fixed inset-x-1/3 mt-2 z-50 flex w-full items-center justify-center overflow-hidden">
            <div class="modal-container z-50 mx-auto w-11/12 overflow-y-auto rounded border border-teal-500 bg-white shadow-lg shadow-lg md:max-w-md">
                <div class="modal-content py-4 px-6 text-left">
                <!--Title-->
                <div class="flex items-center justify-between pb-3">
                    <p class="text-xl font-bold">Notification!</p>
                    <div class="modal-close z-50 cursor-pointer">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                    </div>
                </div>
                <!--Body-->
                <h1>Copy URL Success!</h1>
                </div>
            </div>
        </div>
        `;
    setTimeout(() => {
        document.querySelector(".main-modal").remove();
    }, 1000);
}

function deleteFile(id) {
    fetch(`/users/delete/${id}`, {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
    })
        .then((res) => res.json())
        .then((res) => {
            if (res.success == true) {
                document.getElementById(`file-${id}`).remove();

                document.getElementById("modalbree").innerHTML = `
                <div class="main-modal h-100 animated fadeIn faster fixed inset-x-1/3 mt-2 z-50 flex w-full items-center justify-center overflow-hidden">
                    <div class="modal-container z-50 mx-auto w-11/12 overflow-y-auto rounded border border-teal-500 bg-white shadow-lg shadow-lg md:max-w-md">
                        <div class="modal-content py-4 px-6 text-left">
                        <!--Title-->
                        <div class="flex items-center justify-between pb-3">
                            <p class="text-xl font-bold">Notification!</p>
                            <div class="modal-close z-50 cursor-pointer">
                            <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                            </div>
                        </div>
                        <!--Body-->
                        <h1>Delete File Success!</h1>
                        </div>
                    </div>
                </div>
                `;
                setTimeout(() => {
                    document.querySelector(".main-modal").remove();
                }, 1000);
            }
        })
        .catch((err) => console.log(err));
}

function toggleSidebar() {
    if (sidebar.classList.contains("hidden")) {
        sidebar.classList.remove("hidden");
    } else {
        sidebar.classList.add("hidden");
    }
}