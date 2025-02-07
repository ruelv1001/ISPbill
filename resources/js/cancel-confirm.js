function cancelConfirm(url = 'dashboard', mainTab = 'convention') {
    Swal.fire({
        title: "Are you sure you want to cancel?",
        text: "All unsaved data will be lost.",
        icon: "warning",
        showCancelButton: true,
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.replace('/' + url + '?tab-active=' + mainTab);
        }
    });
}

export { cancelConfirm };
