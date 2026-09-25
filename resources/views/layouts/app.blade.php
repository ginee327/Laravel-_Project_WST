<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mariegine Task Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        blush: {
                            50: '#fff5f7',
                            100: '#fde8ed',
                            200: '#fbd0db',
                            300: '#f7aabf',
                            400: '#f27899',
                            500: '#e84d75',
                        },
                        lavender: {
                            50: '#f8f7fc',
                            100: '#f0eef9',
                            200: '#e1dcf2',
                            300: '#c8bfdf',
                        },
                        cream: '#faf8f5',
                        charcoal: {
                            800: '#2c2a2e',
                            600: '#5c5861',
                            400: '#8c8694',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif']
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,500;0,600;1,400&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fdfbfb 0%, #f4eff4 50%, #fff0f3 100%);
            background-attachment: fixed;
            color: #2c2a2e;
        }
        
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e1dcf2; border-radius: 999px; }
        ::-webkit-scrollbar-thumb:hover { background: #f7aabf; }

        /* Soft ambient gradient orb */
        .ambient-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.45;
            z-index: 0;
            pointer-events: none;
        }

        /* Subtle Luxury Card Styling */
        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 30px -10px rgba(225, 212, 220, 0.5);
        }

        .task-card {
            aspect-ratio: 1 / 1;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Hover Balance & Refined Transition */
        #taskGrid .task-card {
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease, opacity 0.3s ease;
        }
        #taskGrid:hover .task-card {
            opacity: 0.75;
            transform: scale(0.98);
        }
        #taskGrid .task-card:hover {
            opacity: 1;
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 20px 35px -10px rgba(232, 77, 117, 0.15);
            z-index: 10;
        }

        /* Delicate Pill Buttons */
        .btn-elegant {
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .btn-elegant:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px -6px rgba(232, 77, 117, 0.3);
        }
        .btn-elegant:active {
            transform: translateY(0);
        }

        .nav-link {
            transition: all 0.25s ease;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col md:flex-row relative overflow-x-hidden">

    <!-- Decorative Background Ambient Glows -->
    <div class="ambient-orb w-[500px] h-[500px] bg-blush-200 -top-32 -left-32"></div>
    <div class="ambient-orb w-[450px] h-[450px] bg-lavender-200 top-1/3 -right-20"></div>
    <div class="ambient-orb w-[400px] h-[400px] bg-blush-100 bottom-0 left-1/3"></div>

    <!-- Sidebar Navigation -->
    <aside class="relative z-10 w-full md:w-72 glass-card border-b md:border-b-0 md:border-r border-white/60 flex flex-col justify-between shrink-0 md:h-screen md:sticky md:top-0">
        <div>
            <!-- App Branding -->
            <div class="h-28 flex items-center px-8 border-b border-blush-100/60 gap-3.5">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blush-300 to-lavender-300 flex items-center justify-center text-white shadow-sm shrink-0">
                    <i class="fa-solid fa-feather-pointed text-sm"></i>
                </div>
                <div>
                    <h1 class="font-serif font-medium text-2xl tracking-wide text-charcoal-800">Mariegine</h1>
                    <span class="text-[11px] uppercase tracking-widest text-charcoal-400 font-light">Task Manager</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="p-6 space-y-2">
                <a href="#" onclick="filterTasks('all')" id="nav-all" class="nav-link flex items-center gap-3.5 px-5 py-3 rounded-2xl text-xs font-medium bg-gradient-to-r from-blush-400 to-blush-300 text-white shadow-sm shadow-blush-200">
                    <span class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center"><i class="fa-solid fa-border-all text-[10px]"></i></span> 
                    <span>All Tasks</span> 
                    <span id="count-all" class="ml-auto px-2 py-0.5 rounded-full bg-white/20 text-[10px] font-semibold">0</span>
                </a>
                <a href="#" onclick="filterTasks('pending')" id="nav-pending" class="nav-link flex items-center gap-3.5 px-5 py-3 rounded-2xl text-xs font-medium text-charcoal-600 hover:bg-blush-50/70">
                    <span class="w-5 h-5 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center"><i class="fa-regular fa-clock text-[10px]"></i></span> 
                    <span>Pending</span> 
                    <span id="count-pending" class="ml-auto px-2 py-0.5 rounded-full bg-lavender-100 text-charcoal-600 text-[10px] font-semibold">0</span>
                </a>
                <a href="#" onclick="filterTasks('completed')" id="nav-completed" class="nav-link flex items-center gap-3.5 px-5 py-3 rounded-2xl text-xs font-medium text-charcoal-600 hover:bg-blush-50/70">
                    <span class="w-5 h-5 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center"><i class="fa-regular fa-circle-check text-[10px]"></i></span> 
                    <span>Completed</span> 
                    <span id="count-completed" class="ml-auto px-2 py-0.5 rounded-full bg-lavender-100 text-charcoal-600 text-[10px] font-semibold">0</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Profile Footer -->
        <div class="p-6 border-t border-blush-100/60">
            <div class="flex items-center gap-3.5 p-3 rounded-2xl bg-white/50 border border-white/80 shadow-sm">
                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-lavender-200 to-blush-200 text-charcoal-800 flex items-center justify-center font-serif text-xs font-semibold shrink-0">
                    AL
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-medium text-charcoal-800 truncate">Alcos Studio</p>
                    <p class="text-[10px] text-charcoal-400 truncate">Personal Workspace</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="relative z-10 flex-1 flex flex-col min-w-0">

        <!-- Top Header Bar -->
        <header class="h-28 bg-white/40 backdrop-blur-md border-b border-white/60 px-8 md:px-12 flex items-center justify-between gap-6 sticky top-0 z-20">
            <div class="flex items-center gap-4 flex-1 max-w-lg">
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-charcoal-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" id="searchInput" oninput="handleSearch()" placeholder="Search your tasks..." class="w-full bg-white/70 border border-blush-100/80 rounded-full pl-10 pr-4 py-2.5 text-xs text-charcoal-800 placeholder-charcoal-400 focus:outline-none focus:border-blush-300 focus:ring-2 focus:ring-blush-100 transition-all shadow-sm">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <select id="priorityFilter" onchange="applyFilters()" class="bg-white/70 border border-blush-100/80 rounded-full px-4 py-2.5 text-xs text-charcoal-600 focus:outline-none focus:border-blush-300 transition-all shadow-sm hidden sm:block">
                    <option value="all">All Priorities</option>
                    <option value="High">High Priority</option>
                    <option value="Medium">Medium Priority</option>
                    <option value="Low">Low Priority</option>
                </select>
                <button onclick="openCreateModal()" class="btn-elegant px-5 py-2.5 rounded-full bg-gradient-to-r from-blush-400 to-blush-300 text-white text-xs font-medium flex items-center gap-2 shadow-sm shadow-blush-200">
                    <i class="fa-solid fa-plus text-[10px]"></i>
                    <span>New Task</span>
                </button>
            </div>
        </header>

        <!-- Dynamic Flash Notification Banner -->
        <div id="flashMessage" class="hidden mx-8 md:mx-12 mt-6 p-4 rounded-2xl bg-white/80 border border-white flex items-center gap-3 text-xs shadow-sm transition-all duration-300">
            <i id="flashIcon" class="fa-solid text-sm"></i>
            <span id="flashText" class="font-medium text-charcoal-800"></span>
        </div>

        <!-- Dashboard View Container -->
        <div class="p-8 md:p-12 space-y-10 flex-1 max-w-7xl w-full mx-auto">

            <!-- Elegant Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="glass-card rounded-3xl p-6 flex items-center gap-5">
                    <div class="w-12 h-12 rounded-2xl bg-blush-50 text-blush-400 flex items-center justify-center text-sm shrink-0 border border-blush-100">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-charcoal-400 font-medium mb-0.5">Total Tasks</p>
                        <h3 id="statTotal" class="font-serif text-2xl font-semibold text-charcoal-800">0</h3>
                    </div>
                </div>
                <div class="glass-card rounded-3xl p-6 flex items-center gap-5">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-sm shrink-0 border border-amber-100">
                        <i class="fa-regular fa-hourglass-half"></i>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-charcoal-400 font-medium mb-0.5">In Progress</p>
                        <h3 id="statPending" class="font-serif text-2xl font-semibold text-charcoal-800">0</h3>
                    </div>
                </div>
                <div class="glass-card rounded-3xl p-6 flex items-center gap-5">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-sm shrink-0 border border-emerald-100">
                        <i class="fa-regular fa-circle-check"></i>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-charcoal-400 font-medium mb-0.5">Completed</p>
                        <h3 id="statCompleted" class="font-serif text-2xl font-semibold text-charcoal-800">0</h3>
                    </div>
                </div>
            </div>

            <!-- Task Registry Section -->
            <div>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="font-serif font-medium text-xl text-charcoal-800 flex items-center gap-3">
                        Task Overview 
                        <span id="currentFilterBadge" class="font-sans text-[10px] tracking-wider uppercase px-3 py-1 rounded-full bg-lavender-100 text-charcoal-600 font-medium">All Tasks</span>
                    </h2>
                </div>

                <!-- Empty State -->
                <div id="emptyState" class="hidden py-24 text-center glass-card rounded-3xl">
                    <div class="w-12 h-12 mx-auto mb-4 rounded-2xl bg-blush-50 text-blush-300 flex items-center justify-center text-lg border border-blush-100">
                        <i class="fa-solid fa-spa"></i>
                    </div>
                    <h3 class="font-serif font-medium text-base text-charcoal-800">Your space is clear</h3>
                    <p class="text-xs text-charcoal-400 mt-1 font-light">Enjoy the moment, or add a new intention above.</p>
                </div>

                <!-- Task Grid -->
                <div id="taskGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Injected dynamically via JS -->
                </div>
            </div>

        </div>
    </main>

    <!-- Add/Edit Task Modal Dialog -->
    <div id="taskModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-charcoal-800/20 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white/90 backdrop-blur-xl border border-white w-full max-w-lg rounded-3xl overflow-hidden transform scale-95 transition-all duration-300 shadow-2xl" id="modalCard">
            <div class="flex items-center justify-between px-8 py-6 border-b border-blush-100/60 bg-gradient-to-r from-blush-50/50 to-lavender-50/50">
                <h3 id="modalTitle" class="font-serif font-medium text-charcoal-800 text-base flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-full bg-blush-100 text-blush-400 flex items-center justify-center text-xs"><i class="fa-solid fa-plus"></i></span>
                    Create New Task
                </h3>
                <button onclick="closeModal()" class="w-8 h-8 rounded-full hover:bg-blush-50 text-charcoal-400 hover:text-charcoal-800 flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>
            <form id="taskForm" onsubmit="handleFormSubmit(event)" class="p-8 space-y-5">
                <input type="hidden" id="taskId">
                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-medium text-charcoal-600 mb-2">Task Title *</label>
                    <input type="text" id="taskTitle" required placeholder="e.g., Design quarterly presentation..." class="w-full bg-white/80 border border-blush-100 rounded-2xl px-4 py-3 text-xs text-charcoal-800 placeholder-charcoal-400 focus:outline-none focus:border-blush-300 focus:ring-2 focus:ring-blush-100 transition-all">
                </div>
                <div>
                    <label class="block text-[11px] uppercase tracking-wider font-medium text-charcoal-600 mb-2">Description</label>
                    <textarea id="taskDesc" rows="3" placeholder="Add subtle details, subtasks, or links..." class="w-full bg-white/80 border border-blush-100 rounded-2xl px-4 py-3 text-xs text-charcoal-800 placeholder-charcoal-400 focus:outline-none focus:border-blush-300 focus:ring-2 focus:ring-blush-100 transition-all resize-none"></textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-medium text-charcoal-600 mb-2">Priority</label>
                        <select id="taskPriority" class="w-full bg-white/80 border border-blush-100 rounded-2xl px-4 py-2.5 text-xs text-charcoal-800 focus:outline-none focus:border-blush-300 transition-all">
                            <option value="Low">Low Priority</option>
                            <option value="Medium" selected>Medium Priority</option>
                            <option value="High">High Priority</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] uppercase tracking-wider font-medium text-charcoal-600 mb-2">Due Date *</label>
                        <input type="date" id="taskDueDate" required class="w-full bg-white/80 border border-blush-100 rounded-2xl px-4 py-2.5 text-xs text-charcoal-800 focus:outline-none focus:border-blush-300 transition-all">
                    </div>
                </div>
                <div class="pt-6 border-t border-blush-100/60 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-full text-charcoal-600 hover:text-charcoal-800 font-medium text-xs transition-colors">Cancel</button>
                    <button type="submit" class="btn-elegant px-6 py-2.5 rounded-full bg-gradient-to-r from-blush-400 to-blush-300 text-white font-medium text-xs shadow-sm shadow-blush-200">Save Task</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Application Logic Script -->
    <script>
        let tasks = [];
        let currentFilter = 'all';
        let currentSearchQuery = '';

        window.onload = function() {
            const todayStr = new Date().toISOString().split('T')[0];
            document.getElementById('taskDueDate').min = todayStr;
            renderApp();
        };

        function renderApp() {
            updateStats();
            renderTaskGrid();
            updateSidebarCounts();
        }

        function updateStats() {
            document.getElementById('statTotal').innerText = tasks.length;
            document.getElementById('statPending').innerText = tasks.filter(t => t.status === 'pending').length;
            document.getElementById('statCompleted').innerText = tasks.filter(t => t.status === 'completed').length;
        }

        function updateSidebarCounts() {
            document.getElementById('count-all').innerText = tasks.length;
            document.getElementById('count-pending').innerText = tasks.filter(t => t.status === 'pending').length;
            document.getElementById('count-completed').innerText = tasks.filter(t => t.status === 'completed').length;
        }

        function filterTasks(filter) {
            currentFilter = filter;

            const activeClass = "nav-link flex items-center gap-3.5 px-5 py-3 rounded-2xl text-xs font-medium bg-gradient-to-r from-blush-400 to-blush-300 text-white shadow-sm shadow-blush-200";
            const inactiveClass = "nav-link flex items-center gap-3.5 px-5 py-3 rounded-2xl text-xs font-medium text-charcoal-600 hover:bg-blush-50/70";

            ['all', 'pending', 'completed'].forEach(f => {
                const el = document.getElementById(`nav-${f}`);
                el.className = (f === filter) ? activeClass : inactiveClass;
            });

            const badgeNames = { all: 'All Tasks', pending: 'Pending Tasks', completed: 'Completed Tasks' };
            document.getElementById('currentFilterBadge').innerText = badgeNames[filter];

            renderTaskGrid();
        }

        function handleSearch() {
            currentSearchQuery = document.getElementById('searchInput').value.toLowerCase().trim();
            renderTaskGrid();
        }

        function applyFilters() {
            renderTaskGrid();
        }

        function getFilteredTasks() {
            const priorityVal = document.getElementById('priorityFilter').value;
            return tasks.filter(task => {
                if (currentFilter !== 'all' && task.status !== currentFilter) return false;
                if (priorityVal !== 'all' && task.priority !== priorityVal) return false;
                if (currentSearchQuery && !task.title.toLowerCase().includes(currentSearchQuery) && !task.description.toLowerCase().includes(currentSearchQuery)) return false;
                return true;
            });
        }

        function renderTaskGrid() {
            const filtered = getFilteredTasks();
            const grid = document.getElementById('taskGrid');
            const emptyState = document.getElementById('emptyState');

            grid.innerHTML = '';

            if (filtered.length === 0) {
                emptyState.classList.remove('hidden');
                grid.classList.add('hidden');
                return;
            } else {
                emptyState.classList.add('hidden');
                grid.classList.remove('hidden');
            }

            filtered.forEach(task => {
                let priorityBadge = '';
                if (task.priority === 'High') {
                    priorityBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-medium bg-rose-50 text-rose-500 border border-rose-100">High</span>`;
                } else if (task.priority === 'Medium') {
                    priorityBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-medium bg-amber-50 text-amber-600 border border-amber-100">Medium</span>`;
                } else {
                    priorityBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">Low</span>`;
                }

                const isCompleted = task.status === 'completed';
                const statusBadge = isCompleted
                    ? `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-600 border border-emerald-100"><i class="fa-solid fa-check text-[9px]"></i> Done</span>`
                    : `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-medium bg-lavender-100 text-charcoal-600 border border-lavender-200"><i class="fa-regular fa-clock text-[9px]"></i> Pending</span>`;

                const card = document.createElement('div');
                card.className = "task-card glass-card rounded-3xl p-6 flex flex-col justify-between";
                card.innerHTML = `
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-4">
                            ${priorityBadge}
                            ${statusBadge}
                        </div>
                        <h4 class="font-serif font-medium text-base text-charcoal-800 mb-2 leading-snug ${isCompleted ? 'line-through text-charcoal-400' : ''}">${escapeHtml(task.title)}</h4>
                        <p class="text-xs text-charcoal-600 font-light line-clamp-2 leading-relaxed">${escapeHtml(task.description || 'No additional details provided.')}</p>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5 text-[11px] text-charcoal-400 mb-4 pt-4 border-t border-blush-100/60 font-light">
                            <i class="fa-regular fa-calendar text-[10px]"></i> Due ${task.dueDate}
                        </div>
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="toggleTaskStatus('${task.id}')" title="${isCompleted ? 'Reopen' : 'Complete'}" class="w-8 h-8 rounded-full bg-white border border-blush-100 text-charcoal-600 hover:bg-blush-50 hover:text-blush-400 flex items-center justify-center transition-colors">
                                <i class="fa-solid ${isCompleted ? 'fa-rotate-left' : 'fa-check'} text-[10px]"></i>
                            </button>
                            <button onclick="openEditModal('${task.id}')" title="Edit" class="w-8 h-8 rounded-full bg-white border border-blush-100 text-charcoal-600 hover:bg-blush-50 hover:text-blush-400 flex items-center justify-center transition-colors">
                                <i class="fa-solid fa-pen text-[10px]"></i>
                            </button>
                            <button onclick="deleteTask('${task.id}')" title="Delete" class="w-8 h-8 rounded-full bg-white border border-blush-100 text-charcoal-400 hover:bg-rose-50 hover:text-rose-500 flex items-center justify-center transition-colors">
                                <i class="fa-regular fa-trash-can text-[10px]"></i>
                            </button>
                        </div>
                    </div>
                `;
                grid.appendChild(card);
            });
        }

        function openModal() {
            const modal = document.getElementById('taskModal');
            const card = document.getElementById('modalCard');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                card.classList.remove('scale-95');
                card.classList.add('scale-100');
            }, 10);
        }

        function openCreateModal() {
            document.getElementById('taskId').value = '';
            document.getElementById('taskForm').reset();
            document.getElementById('modalTitle').innerHTML = '<span class="w-7 h-7 rounded-full bg-blush-100 text-blush-400 flex items-center justify-center text-xs"><i class="fa-solid fa-plus"></i></span> Create New Task';
            openModal();
        }

        function openEditModal(id) {
            const task = tasks.find(t => t.id === id);
            if (!task) return;

            document.getElementById('taskId').value = task.id;
            document.getElementById('taskTitle').value = task.title;
            document.getElementById('taskDesc').value = task.description;
            document.getElementById('taskPriority').value = task.priority;
            document.getElementById('taskDueDate').value = task.dueDate;
            document.getElementById('modalTitle').innerHTML = '<span class="w-7 h-7 rounded-full bg-blush-100 text-blush-400 flex items-center justify-center text-xs"><i class="fa-solid fa-pen"></i></span> Edit Task';
            openModal();
        }

        function closeModal() {
            const modal = document.getElementById('taskModal');
            const card = document.getElementById('modalCard');
            modal.classList.add('opacity-0');
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function handleFormSubmit(event) {
            event.preventDefault();
            const id = document.getElementById('taskId').value;
            const title = document.getElementById('taskTitle').value.trim();
            const description = document.getElementById('taskDesc').value.trim();
            const priority = document.getElementById('taskPriority').value;
            const dueDate = document.getElementById('taskDueDate').value;

            if (!title || !dueDate) return;

            if (id) {
                tasks = tasks.map(t => t.id === id ? { ...t, title, description, priority, dueDate } : t);
                showFlash('Task successfully updated', 'success');
            } else {
                const newTask = {
                    id: Date.now().toString(),
                    title, description, priority, dueDate,
                    status: 'pending'
                };
                tasks.unshift(newTask);
                showFlash('New task created', 'success');
            }

            closeModal();
            renderApp();
        }

        function toggleTaskStatus(id) {
            tasks = tasks.map(t => {
                if (t.id === id) {
                    const newStatus = t.status === 'completed' ? 'pending' : 'completed';
                    showFlash(`Task marked as ${newStatus}`, 'success');
                    return { ...t, status: newStatus };
                }
                return t;
            });
            renderApp();
        }

        function deleteTask(id) {
            if (confirm('Are you sure you want to delete this task?')) {
                tasks = tasks.filter(t => t.id !== id);
                showFlash('Task removed', 'error');
                renderApp();
            }
        }

        function showFlash(message, type) {
            const flash = document.getElementById('flashMessage');
            const text = document.getElementById('flashText');
            const icon = document.getElementById('flashIcon');

            text.innerText = message;
            if (type === 'success') {
                flash.className = "mx-8 md:mx-12 mt-6 p-4 rounded-2xl bg-white/80 border border-emerald-100 flex items-center gap-3 text-xs shadow-sm transition-all duration-300";
                icon.className = "fa-solid fa-circle-check text-emerald-500 text-sm";
            } else {
                flash.className = "mx-8 md:mx-12 mt-6 p-4 rounded-2xl bg-white/80 border border-rose-100 flex items-center gap-3 text-xs shadow-sm transition-all duration-300";
                icon.className = "fa-solid fa-circle-exclamation text-rose-500 text-sm";
            }

            flash.classList.remove('hidden');
            setTimeout(() => {
                flash.classList.add('hidden');
            }, 3000);
        }

        function escapeHtml(str) {
            return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }
    </script>
</body>
</html>