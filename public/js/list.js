const INPUT_IMPORT = document.querySelector("#input_import");
if (INPUT_IMPORT !== null) {
    INPUT_IMPORT.addEventListener('change', () => {
        const FRM_IMPORT =document.querySelector("#frm_import");
        FRM_IMPORT.submit();
    });
}

let triggerDelete = () => {
    const FRM_DELETE = document.querySelector('#frm_delete');
    FRM_DELETE.submit();
}
