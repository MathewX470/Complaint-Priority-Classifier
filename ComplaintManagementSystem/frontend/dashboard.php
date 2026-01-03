<?php
require_once '../backend/config.php';
require_once '../backend/complaint_api.php';
requireLogin();

$complaintAPI = new ComplaintAPI();
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$result = $complaintAPI->getUserComplaints($_SESSION['user_id'], $page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - Smart Complaint Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            overflow-x: hidden;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transition: transform 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-content {
            padding: 1rem;
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: all 0.3s;
            margin-bottom: 0.5rem;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 1rem;
            transition: margin-left 0.3s ease;
        }
        
        .mobile-header {
            display: none;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .sidebar-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        .priority-badge {
            font-weight: bold;
            padding: 5px 15px;
        }
        
        .status-badge {
            padding: 5px 15px;
        }
        
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        
        /* Mobile Styles */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .sidebar-overlay.show {
                display: block;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            
            .table-responsive {
                font-size: 0.85rem;
            }
            
            .card-header {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .card-header .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Header -->
    <div class="mobile-header">
        <button class="sidebar-toggle" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>
        <h5 class="mb-0"><i class="bi bi-headset"></i> SmartComplaint</h5>
        <span></span>
    </div>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4 class="mb-0"><i class="bi bi-headset"></i> SmartComplaint</h4>
        </div>
        <div class="sidebar-content">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#newComplaintModal" onclick="closeSidebarOnMobile()">
                        <i class="bi bi-plus-circle"></i> New Complaint
                    </a>
                </li>
            </ul>
            <hr class="text-white">
            <div class="user-info">
                <p class="mb-2"><i class="bi bi-person"></i> <?php echo htmlspecialchars($_SESSION['full_name']); ?></p>
                <a href="logout.php" class="btn btn-outline-light btn-sm w-100">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
                <h2 class="mb-4">My Complaints</h2>
                
                <div id="alertMessage"></div>
                
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-list-ul"></i> All Complaints</span>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newComplaintModal">
                            <i class="bi bi-plus"></i> Submit New Complaint
                        </button>
                    </div>
                    <div class="card-body">
                        <?php if ($result['success'] && !empty($result['complaints'])): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Complaint</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Submitted</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($result['complaints'] as $complaint): ?>
                                    <tr>
                                        <td>#<?php echo $complaint['complaint_id']; ?></td>
                                        <td><?php echo htmlspecialchars(substr($complaint['complaint_text'], 0, 100)) . '...'; ?></td>
                                        <td>
                                            <span class="badge priority-badge 
                                                <?php 
                                                echo $complaint['priority'] === 'High' ? 'bg-danger' : 
                                                     ($complaint['priority'] === 'Medium' ? 'bg-warning text-dark' : 
                                                     ($complaint['priority'] === 'Low' ? 'bg-info' : 'bg-secondary')); 
                                                ?>">
                                                <?php echo $complaint['priority']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge status-badge 
                                                <?php 
                                                echo $complaint['status'] === 'Resolved' ? 'bg-success' : 
                                                     ($complaint['status'] === 'In Progress' ? 'bg-primary' : 
                                                     ($complaint['status'] === 'Under Review' ? 'bg-warning text-dark' : 'bg-secondary')); 
                                                ?>">
                                                <?php echo $complaint['status']; ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('M d, Y', strtotime($complaint['submitted_at'])); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewDetails(<?php echo $complaint['complaint_id']; ?>)">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if ($result['pages'] > 1): ?>
                        <nav>
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $result['pages']; $i++): ?>
                                <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                        <?php endif; ?>
                        
                        <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 60px; color: #ccc;"></i>
                            <p class="mt-3">No complaints yet. Submit your first complaint!</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Complaint Modal -->
    <div class="modal fade" id="newComplaintModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Submit New Complaint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="complaintForm">
                        <div class="mb-3">
                            <label for="complaintText" class="form-label">Describe your complaint</label>
                            <textarea class="form-control" id="complaintText" rows="6" required></textarea>
                            <div class="form-text">Our AI will automatically classify the priority of your complaint</div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> Submit Complaint
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Complaint Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailsContent">
                    <!-- Content loaded dynamically -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('complaintForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const complaintText = document.getElementById('complaintText').value;
            
            try {
                const response = await fetch('../backend/submit_complaint.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ complaint_text: complaintText })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert('success', 'Complaint submitted successfully! Priority: ' + data.priority);
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showAlert('danger', data.message);
                }
            } catch (error) {
                showAlert('danger', 'Failed to submit complaint. Please try again.');
            }
        });
        
        async function viewDetails(complaintId) {
            try {
                const response = await fetch(`../backend/get_complaint_details.php?id=${complaintId}`);
                const data = await response.json();
                
                if (data.success) {
                    let html = `
                        <div class="mb-3">
                            <h6>Complaint Text:</h6>
                            <p>${data.details.complaint_text}</p>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Priority:</strong> <span class="badge bg-${getPriorityColor(data.details.priority)}">${data.details.priority}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Status:</strong> <span class="badge bg-${getStatusColor(data.details.status)}">${data.details.status}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Submitted:</strong> ${new Date(data.details.submitted_at).toLocaleString()}
                        </div>
                        <h6 class="mt-4">Status History:</h6>
                        <ul class="list-group">
                    `;
                    
                    data.history.forEach(item => {
                        html += `
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span><strong>${item.old_status || 'Initial'}</strong> → <strong>${item.new_status}</strong></span>
                                    <small>${new Date(item.changed_at).toLocaleString()}</small>
                                </div>
                                ${item.notes ? `<div class="mt-1"><small>${item.notes}</small></div>` : ''}
                            </li>
                        `;
                    });
                    
                    html += '</ul>';
                    document.getElementById('detailsContent').innerHTML = html;
                    new bootstrap.Modal(document.getElementById('detailsModal')).show();
                }
            } catch (error) {
                showAlert('danger', 'Failed to load details.');
            }
        }
        
        function getPriorityColor(priority) {
            const colors = { High: 'danger', Medium: 'warning', Low: 'info', Other: 'secondary' };
            return colors[priority] || 'secondary';
        }
        
        function getStatusColor(status) {
            const colors = { 
                Resolved: 'success', 
                'In Progress': 'primary', 
                'Under Review': 'warning', 
                Registered: 'secondary' 
            };
            return colors[status] || 'secondary';
        }
        
        function showAlert(type, message) {
            const alertDiv = document.getElementById('alertMessage');
            alertDiv.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`;
        }
        
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }
        
        function closeSidebarOnMobile() {
            if (window.innerWidth <= 768) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }
        }
    </script>
</body>
</html>
