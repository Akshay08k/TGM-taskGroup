<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Workgroup Members | Task Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 flex justify-between items-center">
        <div class="text-white text-xl font-bold">TGM - Task Group Management</div>
        <div class="text-white">
            Welcome, <span id="username" class="font-semibold">Team Leader</span>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="flex">
        <aside class="sidebar w-64 h-screen bg-gradient-to-br from-blue-800 to-blue-600 text-white shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">TGM Dashboard</h2>
                <ul>
                    <li class="mb-4">
                        <a href="team_leader_dashboard.php"
                            class="flex items-center space-x-4 p-3 hover:bg-blue-700 rounded-lg transition duration-200">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="create_workgroup.php"
                            class="flex items-center space-x-4 p-3 hover:bg-blue-700 rounded-lg transition duration-200">
                            <i class="fas fa-users"></i>
                            <span>Create Workgroup</span>
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="assign_task.php"
                            class="flex items-center space-x-4 p-3 hover:bg-blue-700 rounded-lg transition duration-200">
                            <i class="fas fa-tasks"></i>
                            <span>Assign Tasks</span>
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="view_tasks.php"
                            class="flex items-center space-x-4 p-3 hover:bg-blue-700 rounded-lg transition duration-200">
                            <i class="fas fa-eye"></i>
                            <span>View Tasks</span>
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="view_members.php"
                            class="flex items-center space-x-4 p-3 hover:bg-blue-700 rounded-lg transition duration-200">
                            <i class="fas fa-user-friends"></i>
                            <span>View Users</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">View Workgroup Members</h1>

            <table class="w-full bg-white shadow-md rounded-md">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-4">Name</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Workgroup</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody id="member-list">
                    <!-- Dynamic list of users in workgroup -->
                    <tr>
                        <td class="p-4">John Doe</td>
                        <td class="p-4">john@example.com</td>
                        <td class="p-4">workgroup-1</td>
                        <td class="p-4">
                            <button onclick="openDeleteModal(1)"
                                class="bg-red-600 text-white py-1 px-3 rounded-md hover:bg-red-700">Remove</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="p-4">Jane Smith</td>
                        <td class="p-4">jane@example.com</td>
                        <td class="p-4">workgroup-1</td>
                        <td class="p-4">
                            <button onclick="openDeleteModal(2)"
                                class="bg-red-600 text-white py-1 px-3 rounded-md hover:bg-red-700">Remove</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </main>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteMemberModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
            <h2 class="text-lg font-semibold mb-4">Remove Member</h2>
            <p>Are you sure you want to remove this member?</p>
            <input type="hidden" id="deleteMemberId">
            <div class="mt-4 flex justify-end">
                <button id="confirmDeleteButton"
                    class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700">Remove</button>
                <button onclick="closeModal('deleteMemberModal')" class="ml-2 text-gray-500">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(memberId) {
            document.getElementById('deleteMemberId').value = memberId;
            document.getElementById('deleteMemberModal').classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Handle Remove Member
        document.getElementById('confirmDeleteButton').addEventListener('click', function () {
            const memberId = document.getElementById('deleteMemberId').value;

            // Make an AJAX request to remove the member
            fetch('remove_member.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: memberId })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Member removed successfully!');
                        location.reload();
                    } else {
                        alert('Error removing member: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

</body>

</html>