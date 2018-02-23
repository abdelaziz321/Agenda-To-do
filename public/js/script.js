/*global $*/
/*============================================
* Author    : Abdelaziz Selim  (^‿^)
* Email     : abdelazizmahmoud321@gmail.com
* Project   : Agenda - todo Tasks
* Version   : 1.0
----------------------------------------------
        *** TABLE OF CONTENTS ***
----------------------------------------------
    * 00. General
    * 01. Task functions
    * 02. Note functions
    * 03. Profile Section functions
    * 04. Message functions
==============================================*/

$(document).ready(function () {
    "use strict";

        // $General
    var mainPage = $('body > .main'),
        todoSection = $('body > .main > .todo'),
        tasks = $('.todo .list .tasks'),
        sidebar = $('.sidebar'),
        // $navBtn
        navBtn = $('#navbar_btn'),
        navicon = $('#navbar_btn i'),
        // $Task
        addTaskBtn = $('#add_task'),
        saveTaskBtn = $('#save_task'),
        taskDialog = $('.dialog'),
        taskDateInput = $('.dialog .body #date'),
        taskTimeInput = $('.dialog .body #time'),
        taskBodyInput = $('.dialog .body #task_editor'),
        taskPriorityRadio = $('.dialog .body input[name="priority"]'),
        taskIdInput = $('.dialog .body #id'),
        closeDialog = $('html, #dialog_close'),
        draggableOptions = {
            start: function (event, ui) {
                $(ui.helper).width(tasks.find('.task').width());
            },
            containment: '.todo',
            zIndex: 3,
            cursor: 'move',
            revert: 'invalid',
            helper: "clone",
            appendTo: '#draggable_helper'
        },
        // $Note
        userNotes = $('.sidebar .notes ul'),
        addNoteBtn = $('#add_note'),
        noteDialog = null,
        noteTitle = null,
        noteEditor = null,
        noteIdInput = null,
        noteCreated = null,
        saveNoteBtn = null,
        deleteNoteBtn = null,
        // $Profile
        editProfileBtn = $('#edit-profile'),
        logout = $('#logout'),
        profileSection = null,
        resetToggle = null,
        resetSection = null,
        skinToggle = null,
        skinSection = null,
        skinPalette = null,
        colorInput1 = null,
        colorInput2 = null,
        bColorInput = null,
        closeEditProfile = null,
        messageDialog = $('.message'),
        messageStatus= $('.message span'),
        messageContent = $('.message p'),
        closeMessageBtn = $('.message #close_message');

    // On Navbar Button [click] => toggle the Sidebar
    navBtn.on('click', function() {
        mainPage.toggleClass('hidesidebar');
        navicon.toggleClass('ion-navicon-round').toggleClass('ion-close');
        navBtn.toggleClass('changenavbtn');
    });

    // Run the editor inside the task dialog
    $('#task_editor').froalaEditor({
        heightMin: 150
    });

    // Add new task
    addTaskBtn.on('click', function (event) {
        resetTaskDialog();
        showTaskDialog();
        event.stopPropagation();
    });

    // Edit task
    $(document).on('click', '.task .btns a.edit_task', function(event) {
        event.preventDefault();
        fillTaskDialog($(this).parents('.task'));
        showTaskDialog();
    });

    // Close the task dialog
    closeDialog.on('click', function () {
        hideTaskDialog();
    });
    taskDialog.on('click', function (event) {
        event.stopPropagation();
    });

    // Send the new|edit task request
    saveTaskBtn.on('click', function(event) {
        event.preventDefault();
        var form = $(this).parents('form'),
            formData = new FormData(form[0]);

        if (taskIdInput.val() == 0) {
            addTaskRequest(form, formData);
        } else {
            editTaskRequest(form, formData);
        }
    });

    // delete the task from the database & DOM
    $(document).on('click', '.task .btns a.delete_task', function(event) {
        event.preventDefault();
        var task = $(this).parents('.task'),
            url = $(this).attr('href');

        deleteTaskRequest(task, url);   // TODO: Undo message
    });

    // Drag & Drop Tasks
    tasks.find('.task').draggable(draggableOptions);

    tasks.droppable({
        accept: '.tasks .task',
        hoverClass: 'hovered',
        drop: moveTask,
    });

    // Open the Note dialog
    addNoteBtn.on('click', function (event) {
        event.preventDefault();
        // Get Note dialog usaing Ajax at the first time
        if (noteDialog === null) {
            var url = $(this).attr('href');
            getNoteDialog(url);
        } else {
            resetNoteDialog();
        }
        event.stopPropagation();
    });

    // Edit note
    userNotes.on('click', 'li.note > a', function(event) {
        event.preventDefault();
        // get the note
        var noteBtn = $(this);
        getNote(noteBtn);
    });

    // Open Edit Profile Section
    editProfileBtn.on('click', function (event) {
        event.preventDefault();
        if (profileSection === null) {
            var url = $(this).attr('href');
            getProfileSection(url);
        } else {
            showProfileSection();
        }
    });

    // Logout user and redirect to authanticate page
    logout.on('click', function (event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            type: 'POST',
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        })
        .done(function(data) {
            window.location = data.url;
        });

    });

    // Using Slim Scroll in the 4 task list sections
    tasks.slimScroll({
        height: $('.todo .list').innerHeight() - $('.todo .list h3').outerHeight() - 60 + 'px',
        alwaysVisible: false,
        wheelStep: 6,
        color: 'rgba(255,255,255,0.3)'
    });

    // Using Slim scroll in the userNotes
    userNotes.slimScroll({
        height: '130px',
        alwaysVisible: false,
        wheelStep: 6,
        color: 'rgba(255,255,255,0.3)'
    });

    // Resize Slim scroll
    $(window).on('resize', function(){
        var newTasksHeight = $('.todo .list').innerHeight() - $('.todo .list h3').outerHeight() - 60;
        $('.todo .list .slimScrollDiv').height(newTasksHeight);
        tasks.height(newTasksHeight);
    });

    closeMessageBtn.on('click', function() {
        hideMessage();
    });

    $(document).ajaxStart(function() {
        loadingMessage();
    });

    $(document).ajaxComplete(function(event, xhr, settings) {
        if (messageContent.text() == 'Loading.....') {
            hideMessage();
        }
    });

    $(document).ajaxError(function(event, xhr, settings, thrownError) {
        var errors = JSON.parse(xhr.responseText).errors,
            message = '';
        for (var error in errors) { message += (errors[error] + ' '); }
        showMessage(message, 'red');
    });


    /*----------------------------------------------
    *   01. Task functions
    *----------------------------------------------*/
    function resetTaskDialog() {
        taskIdInput.val(0);
        taskBodyInput.froalaEditor('html.set', '');
        taskBodyInput.froalaEditor('undo.saveStep');
        taskPriorityRadio.prop("checked", false);
        taskPriorityRadio.filter('#low').prop("checked", true);
    }

    function fillTaskDialog(task) {
        var id = task.data('id'),
            body = task.find('.description').html(),
            deadline = new Date(task.find('#timestamp').text()),
            date = deadline.getFullYear() + '-' + ('0' + (deadline.getMonth() + 1)).slice(-2) + '-' + ('0' + deadline.getDate()).slice(-2),
            time = ('0' + deadline.getHours()).slice(-2) + ':' + ('0' + deadline.getMinutes()).slice(-2),
            pattern = /(low|mid|high)/g,
            priority = task.attr('class').match(pattern)[0];

        taskIdInput.val(id);
        taskBodyInput.froalaEditor('html.set', body);
        taskBodyInput.froalaEditor('undo.saveStep');
        taskPriorityRadio.prop("checked", false);
        taskPriorityRadio.filter('[id="' + priority + '"]').prop("checked", true);
        taskDateInput.val(date);
        taskTimeInput.val(time);
    }

    function showTaskDialog() {
        if (!taskDialog.hasClass('show')) {
            taskDialog.removeClass('hide');
            setTimeout(function () {
                taskDialog.addClass('show');
            }, 100);

        }
    }

    function hideTaskDialog() {
        if (taskDialog.hasClass('show')) {
            taskDialog.removeClass('show');
            setTimeout(function () {
                taskDialog.addClass('hide'); // to hide the default browser btns
            }, 300);
        }
    }

    function addTaskRequest(form, formData) {
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
            data: formData,
            processData: false,
            contentType: false
        })
        .done(function(data) {
            $('.todo .list.' + data.section + ' .tasks').prepend(data.newTask);
            showMessage(data.status, 'green');
            $(document).find('.task[data-id="' + $(data.newTask).data('id') + '"]').draggable(draggableOptions);
        });

    }

    function editTaskRequest(form, formData) {
        var id = form.find('#id').val(),
            url = form.data('route') + '/' + id;

        formData.append('_method', 'PUT');
        formData.append('_token', $('meta[name=_token]').attr('content'));

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false
        })
        .done(function(data) {
            $('.todo .list .tasks .task[data-id="' + id + '"]').remove();
            $('.todo .list.' + data.section + ' .tasks').prepend(data.newTask);
            showMessage(data.status, 'green');
            $(document).find('.task[data-id="' + $(data.newTask).data('id') + '"]').draggable(draggableOptions);
        });
    }

    function deleteTaskRequest(task, url) {
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {
                '_method': 'DELETE',
                '_token': $('meta[name=_token]').attr('content')
            }
        })
        .done(function(data) {
            showMessage(data.status, 'green');
            task.fadeOut(500);
            setTimeout(function() {
                task.remove();
            }, 500);
        });
    }

    function moveTask (event, ui) {
        var task = ui.draggable,
            sections = /(today|comming|tomorrow|overdue)/g,
            sectionFrom = task.parents('.list').attr('class').match(sections)[0],
            sectionTo = $(event.target).parents('.list').attr('class').match(sections)[0];

        if (sectionFrom !== sectionTo) {
            moveTaskRequest(task, sectionFrom, sectionTo)
        }
    }

    function moveTaskRequest(task, from, to) {
        $.ajax({
            url: task.data('move'),
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
            data: {
                sectionFrom: from,
                sectionTo: to
            }
        })
        .done(function(data) {
            showMessage(data.status, 'green');
            $('.todo .list .tasks .task[data-id="' + $(data.task).data('id') + '"]').remove();
            $('.todo .list.' + data.section + ' .tasks').prepend(data.task);
            $(document).find('.task[data-id="' + $(data.task).data('id') + '"]').draggable(draggableOptions);
        });
    }

    /*----------------------------------------------
    *   02. Note functions
    *----------------------------------------------*/
    function resetNoteDialog() {
        var date = new Date(Date.now()),
            created = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + ' ' + date.getHours() + ':' + ('0' + date.getMinutes()).slice(-2);

        noteTitle.val('New Note');
        noteEditor.froalaEditor('html.set', '');
        noteIdInput.val(0);
        noteCreated.text(created);
        deleteNoteBtn.hide();
        showNoteDialog();
    }

    function fillNoteDialog(note) {
        var date = new Date(note.created.date),
            created = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + ' ' + date.getHours() + ':' + ('0' + date.getMinutes()).slice(-2);

        noteTitle.val(note.title);
        noteEditor.froalaEditor('html.set', note.body);
        noteEditor.froalaEditor('undo.saveStep');
        noteIdInput.val(note.id);
        noteCreated.text(created);
        deleteNoteBtn.fadeIn();
        showNoteDialog();
    }

    function getNoteDialog(url, note) {
        $.ajax({
            url: url,
            type: 'GET'
        })
        .done(function(data) {
            noteDialog = $(data);
            saveNoteBtn = noteDialog.find('#save_note');
            noteTitle = noteDialog.find('#title');
            noteEditor = noteDialog.find('#note_editor');
            noteIdInput = noteDialog.find('#id');
            noteCreated = noteDialog.find('p time');
            deleteNoteBtn = noteDialog.find('#delete_note');
            todoSection.prepend(noteDialog);

            $('#note_editor').froalaEditor({ heightMin: 500 });
            if (note == null) {
                resetNoteDialog();
            } else {
                fillNoteDialog(note);
            }
            noteDialogEvents();
        });
    }

    function noteDialogEvents() {
        // Close the note dialog
        $('html, #note_close').on('click', function () {
            if (noteDialog.hasClass('show')) {
                noteDialog.removeClass('show');
            }
        });
        noteDialog.on('click', function (event) {
            event.stopPropagation();
        });

        saveNoteBtn.on('click', function(event) {
            event.preventDefault();

            var form = $(this).parents('form'),
                formData = new FormData(form[0]);

            if (noteIdInput.val() == 0) {
                addNoteRequest(form, formData);
            } else {
                editNoteRequest(form, formData);
            }
        });

        deleteNoteBtn.on('click', function(event) {
            event.preventDefault();
            var id = noteDialog.find('form #id').val(),
                url = $(this).attr('href') + '/' + id;

            deleteNoteRequest(url);
        });
    }

    function showNoteDialog() {
        if (todoSection.hasClass('hide')) {
            showTodoSection();
        }

        if (noteDialog.hasClass('show')) {
            return;
        }
        noteDialog.addClass('show');

        // to wait for the transition and resize the editor
        setTimeout(function () {
            $('#note_editor').data('froala.editor').opts.height = $('.note_dialog').innerHeight() - 250;
            $('#note_editor').froalaEditor('size.refresh');
        }, 500);
    }

    function getNote(noteBtn) {
        var url = noteBtn.attr('href');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json'
        })
        .done(function(note) {
            // get Note dialog usaing Ajax at the first time
            if (noteDialog === null) {
                var url = noteBtn.parents('.notes').find('#add_note').attr('href');
                getNoteDialog(url, note);
            } else {
                fillNoteDialog(note);
            }
        });
    }

    function addNoteRequest(form, formData) {

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
            data: formData,
            processData: false,
            contentType: false
        })
        .done(function(data) {
            userNotes.prepend(data.newNote);
            showMessage(data.status, 'green');
        });

    }

    function editNoteRequest(form, formData) {
        var id = form.find('#id').val(),
            url = form.data('route') + '/' + id;

        formData.append('_method', 'PUT');
        formData.append('_token', $('meta[name=_token]').attr('content'));

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false
        })
        .done(function(data) {
            userNotes.find('li > a[href$="\/' + data.id + '"]').remove();
            userNotes.prepend(data.newNote);
            showMessage(data.status, 'green');
        });
    }

    function deleteNoteRequest(url) {
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {
                '_method': 'DELETE',
                '_token': $('meta[name="_token"]').attr('content')
            }
        })
        .done(function(data) {
            var note = userNotes.find('li > a[href$="\/' + data.id + '"]');
            note.fadeOut();
            setTimeout(function () {
                note.remove();
            }, 500);
            showMessage(data.status, 'green');
        });
        resetNoteDialog();
    }

    /*----------------------------------------------
    *  03. Profile Section functions
    *----------------------------------------------*/
    function getProfileSection(url) {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html'
        })
        .done(function(data) {
            profileSection = $(data);
            resetToggle = profileSection.find('#reset_toggle');
            resetSection = profileSection.find('.profile_form .panel.reset_section .panel-body');
            skinToggle = profileSection.find('#skin_toggle');
            skinSection = profileSection.find('.profile_form .panel.skin_section .panel-body');
            skinPalette = profileSection.find('.profile_form .panel .skin_form .skin_palette');
            colorInput1 = profileSection.find('#color1');
            colorInput2 = profileSection.find('#color2');
            bColorInput = profileSection.find('#bcolor');
            closeEditProfile = profileSection.find('#profile_close');

            todoSection.after(profileSection);
            profileSectionEvents();
            setBackgroundSpan();
            showProfileSection();
        });

    }

    function profileSectionEvents() {
        // Toggle Edit profile reset password section
        resetToggle.on('click', function(event) {
            event.preventDefault();
            resetSection.slideToggle();
        });

        // Toggle Edit profile Change my Skin
        skinToggle.on('click', function(event) {
            event.preventDefault();
            skinSection.slideToggle();
        });

        // Put the values of our 2 colors in the inputs to send them
        skinPalette.on('click', function() {
            skinPalette.removeClass('checked');
            $(this).addClass('checked');

            if ($(this).data('new')) {
                colorInput1.attr('type', 'color');
                colorInput2.attr('type', 'color');
                bColorInput.attr('type', 'color');
                return;
            }
            colorInput1.attr('value', $(this).children().first().data('color'));
            colorInput2.attr('value', $(this).children().last().data('color'));
            bColorInput.attr('value', $(this).data('bcolor'));

            colorInput1.attr('type', 'hidden');
            colorInput2.attr('type', 'hidden');
            bColorInput.attr('type', 'hidden');
        });

        $('#send_email').on('click', function(event) {
            event.preventDefault();
            var form = $(this).parents('form'),
                url = form.attr('action'),
                formData = new FormData(form[0]);

            sendEmailRequest(url, formData);
        });

        // Change the preference user skin
        $('#change_skin').on('click', function(event) {
            event.preventDefault();
            var url =  $(this).parents('form').attr('action');
            updateSkinRequest(url);
        });

        // Retern to the todo lists
        closeEditProfile.on('click', function() {
            showTodoSection();
        });

        // Update name || photo
        $('#update_profile').on('click', function(event) {
            event.preventDefault();
            var url = $(this).parents('form').attr('action'),
                formData = new FormData($('.edit_form form')[0]);

            updateProfileRequest(url, formData);
        });
    }

    function updateSkinRequest(url) {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
            data: {
                color1: colorInput1.val(),
                color2: colorInput2.val(),
                bcolor: bColorInput.val()
            }
        })
        .done(function(data) {
            $('.future').css('background-color', data.color1);
            $('.past').css('background-color', data.color2);
            sidebar.css('background-color', data.bcolor);
            showMessage('Done ^^', 'green');
        });
        showTodoSection();
    }

    function updateProfileRequest(url, formData) {
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
            contentType: false,
            cache: false,
            processData: false,
            data: formData
        })
        .done(function(data) {
            sidebar.find('.profile_info img').attr('src', data.photo);
            sidebar.find('.profile_info h4').text(data.name);
            showMessage(data.status, 'green');
        });
    }

    function sendEmailRequest(url, formData) {
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
            data: formData,
            processData: false,
            contentType: false
        })
        .done(function(data) {
            showMessage(data.status, 'green');
        });
    }

    // spans background in the 'change my skin' section
    function setBackgroundSpan() {
        var spans = $('.profile .profile_form .panel .skin_form .skin_palette span');
        for (var i=0; i<spans.length; i++) {
            $(spans[i]).css('background-color', $(spans[i]).data('color'));
        }
    }

    function showTodoSection() {
        todoSection.toggleClass('hide');
        profileSection.toggleClass('show take_place');
        resetSection.slideUp();
        skinSection.slideUp();
    }

    function showProfileSection() {
        if (profileSection.hasClass('take_place')) {
            return;
        }
        todoSection.toggleClass('hide');
        profileSection.toggleClass('show take_place');
    }

    /*----------------------------------------------
    *  04. Messgae unctions
    *----------------------------------------------*/
    function showMessage(message, status) {
        messageStatus.removeClass().addClass(status);
        messageContent.text(message)
        messageDialog.addClass('up');

        setTimeout(function () {
            messageDialog.removeClass('up');
        }, 5000);
    }

    function hideMessage() {
        if (messageDialog.hasClass('up')) {
            messageDialog.removeClass('up');
        }
    }

    function loadingMessage() {
        messageStatus.removeClass().addClass('yellow');
        messageContent.text('Loading.....')
        messageDialog.addClass('up');
    }

});
