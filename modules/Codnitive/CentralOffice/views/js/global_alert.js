var before_del, after_del, before_post, after_post;
before_del = {
    icon: 'error',
    toast: false,
    position: 'center',
    title: 'عملیات حذف اطلاعات',
    text: "آیا انجام شود؟",
    type: 'error',
    customClass: {
        icon: 'swal2-arabic-question-mark'
    },
    focusCancel: true,
    background: 'rgba(255,255,255)',
    width: '60rem',
    allowOutsideClick: false,
    allowEscapeKey: true,
    allowEnterKey: true,
    animation: false,
    // confirmButtonColor: 'rgb(255,100,100)',
    // cancelButtonColor: 'rgb(50,150,50)',
    confirmButtonText: 'بلی، اطمینان دارم',
    cancelButtonText: 'خیر',
    showCancelButton: true,
    showCloseButton: false,
};
after_del = {
    title: "حذف اطلاعات",
    text: "انجام شد",
    type: "success",
    width: '60rem',
    background: 'rgba(255,255,255)',
    animation: false,
    confirmButtonClass: "btn-info",
    // confirmButtonText: 'OK',
    allowEnterKey: true,
    timer: 900,
    focusConfirm: true,
    showCancelButton: false,
    showConfirmButton: false,
};
before_post = {
    title: "ارسال اطلاعات",
    text: "آیا انجام شود؟",
    type: "warning",
    showCancelButton: true,
    animation: false,
    background: 'rgba(255,255,255)',
    width: '60rem',
    confirmButtonText: "بلی",
    cancelButtonText: "خیر",
    closeOnConfirm: true,
    confirmButtonClass: "btn-danger",
    allowEscapeKey: true,
    focusConfirm: true,
    focusCancelButton: false,
    allowEnterKey: true,
    allowOutsideClick: false,
};
after_post = {
    title: "ارسال اطلاعات",
    text: "انجام شد",
    type: "info",
    background: 'rgba(255,255,255)',
    width: '60rem',
    animation: false,
    timer: 1800,
    allowEnterKey: true,
    showCancelButton: false,
    showConfirmButton: false,
};

function custom_alert(title = '', msg = '', time = 1800) {
    return {
        title: title,
        text: msg,
        type: "info",
        background: 'rgba(255,255,255)',
        width: '60rem',
        animation: false,
        timer: time,
        allowEnterKey: true,
        showCancelButton: false,
        showConfirmButton: false,
    }
}

function custom_alert_confirm(title = '', msg = '') {
    return {
        icon: 'error',
        toast: false,
        position: 'center',
        title: title,
        text: msg,
        type: 'error',
        customClass: {
            icon: 'swal2-arabic-question-mark'
        },
        focusCancel: true,
        background: 'rgba(255,255,255)',
        width: '60rem',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: true,
        animation: false,
        confirmButtonText: 'بلی، اطمینان دارم',
        cancelButtonText: 'خیر',
        showCancelButton: true,
        showCloseButton: false,
    }
}