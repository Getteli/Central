// é necessario um pequeno script para executar a ação de exibir um menu suspenso em um botao action
// floating action button
const elemensBtns = document.querySelectorAll(".fixed-action-btn");
const floatingBtn = M.FloatingActionButton.init(elemensBtns, {
    direction: "left",
    hoverEnabled: false,
});

// navbar
//
const ElemensDropdown = document.querySelectorAll(".dropdown-trigger");
const InstanceDropdown = M.Dropdown.init(ElemensDropdown,{
    coverTrigger: false,
});

// navbar menu mobile
//
const ElemensDropdownMenuMobile = document.querySelectorAll(".sidenav");
const InstanceDropdownMenuMobile = M.Sidenav.init(ElemensDropdownMenuMobile,{
    edge: "right",
    draggable: true,
});

// modal
//
const ElemensModal = document.querySelectorAll(".modal");
const InstanceModal = M.Modal.init(ElemensModal);

// tooltip
const ElemnsTooltip = document.querySelectorAll(".tooltipped");
const instanceTooltip = M.Tooltip.init(ElemnsTooltip,{
    html: "olha essa dica Hello World",
    position: "right"
});

// toast
const ElemensToast = document.querySelector("#toast");
const InstanceToast = () =>{
    M.toast({
        html:"Segunda forma de exibir uma notificacao",
        classes: "rounded"
    })
}

if(ElemensToast){
    ElemensToast.addEventListener("click", () => {
        // 1° forma
        // const instanceToast = M.toast({
        //     html:"Sou uma notificação",
        // });

        // 2° forma
        InstanceToast();
    });
}