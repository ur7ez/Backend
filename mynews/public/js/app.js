let myApp = angular.module('myNews', []);

let menuController = function () {
    this.menuItems = [
        {
            menu: 'File', submenu: [
                {name: 'New document', imgClass: 'fas fa-file-alt'},
                {name: 'Save as...', imgClass: 'fas fa-save'},
                {name: 'Open recent', imgClass: 'fas fa-folder-open'},
                {name: 'Exit'},
            ]
        },
        {
            menu: 'Edit', submenu: [
                {name: 'Cut', imgClass: 'fas fa-cut'},
                {name: 'Copy', imgClass: 'far fa-copy'},
                {name: 'Paste', imgClass: 'fas fa-clipboard'},
                {name: 'Delete', imgClass: 'fa-trash'},
                {name: 'Select all'},
            ]
        },
        {
            menu: 'Insert', submenu: [
                {name: 'Object from ...', imgClass: 'far fa-object-ungroup'},
                {name: 'Image ...', imgClass: 'far fa-image'},
                {name: 'Text File ...', imgClass: 'far fa-file-alt'},
                {
                    name: 'Table', imgClass: 'fas fa-table',
        submenu: [
                        {name: 'insert columns ...'},
                        {name: 'insert rows ...'},
                        {name: 'draw grids', imgClass: 'fas fa-th'},
                        {name: 'fill color'},
                    ]
                },
            ]
        },
    ];
};

myApp.controller('menuController', menuController);