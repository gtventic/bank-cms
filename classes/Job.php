<?php
/**
 * Job Class
 * Handles job openings and applications management
 */

class Job {
    private $db;

    public function __construct() {
        $this->db = new Database();
        $this->db->connect();
    }

    /**
     * Get all job openings
     */
    public function getAllJobs($limit = null, $offset = 0) {
        $sql = '
            SELECT id, title, department, description, requirements, salary_range, 
                   employment_type, location, status, created_at
            FROM jobs
            WHERE status = "active"
            ORDER BY created_at DESC
        ';
        
        if ($limit) {
            $sql .= ' LIMIT :limit OFFSET :offset';
        }
        
        $this->db->query($sql);
        if ($limit) {
            $this->db->bind(':limit', $limit, PDO::PARAM_INT);
            $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        }
        
        return $this->db->resultSet();
    }

    /**
     * Get job by ID
     */
    public function getJobById($id) {
        $this->db->query('
            SELECT id, title, department, description, requirements, salary_range, 
                   employment_type, location, status, created_at
            FROM jobs
            WHERE id = :id
        ');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Create job opening
     */
    public function createJob($data) {
        if (empty($data['title']) || empty($data['department'])) {
            return ['success' => false, 'message' => 'Title and department are required'];
        }

        $this->db->query('
            INSERT INTO jobs (title, department, description, requirements, salary_range, 
                            employment_type, location, status, created_at)
            VALUES (:title, :department, :description, :requirements, :salary_range, 
                   :employment_type, :location, :status, NOW())
        ');
        
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':department', $data['department']);
        $this->db->bind(':description', $data['description'] ?? '');
        $this->db->bind(':requirements', json_encode($data['requirements'] ?? []));
        $this->db->bind(':salary_range', $data['salary_range'] ?? '');
        $this->db->bind(':employment_type', $data['employment_type'] ?? 'Full-time');
        $this->db->bind(':location', $data['location'] ?? '');
        $this->db->bind(':status', $data['status'] ?? 'active');

        if ($this->db->execute()) {
            return ['success' => true, 'message' => 'Job opening created successfully', 'id' => $this->db->lastInsertId()];
        }
        
        return ['success' => false, 'message' => 'Failed to create job opening'];
    }

    /**
     * Update job opening
     */
    public function updateJob($id, $data) {
        $job = $this->getJobById($id);
        if (!$job) {
            return ['success' => false, 'message' => 'Job not found'];
        }

        $this->db->query('
            UPDATE jobs 
            SET title = :title, department = :department, description = :description, 
                requirements = :requirements, salary_range = :salary_range, 
                employment_type = :employment_type, location = :location, status = :status
            WHERE id = :id
        ');
        
        $this->db->bind(':id', $id);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':department', $data['department']);
        $this->db->bind(':description', $data['description'] ?? '');
        $this->db->bind(':requirements', json_encode($data['requirements'] ?? []));
        $this->db->bind(':salary_range', $data['salary_range'] ?? '');
        $this->db->bind(':employment_type', $data['employment_type'] ?? 'Full-time');
        $this->db->bind(':location', $data['location'] ?? '');
        $this->db->bind(':status', $data['status'] ?? 'active');

        return $this->db->execute() ? 
            ['success' => true, 'message' => 'Job updated successfully'] :
            ['success' => false, 'message' => 'Failed to update job'];
    }

    /**
     * Delete job opening
     */
    public function deleteJob($id) {
        $job = $this->getJobById($id);
        if (!$job) {
            return ['success' => false, 'message' => 'Job not found'];
        }

        $this->db->query('DELETE FROM jobs WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->execute() ? 
            ['success' => true, 'message' => 'Job deleted successfully'] :
            ['success' => false, 'message' => 'Failed to delete job'];
    }

    /**
     * Create job application
     */
    public function applyForJob($jobId, $applicantData) {
        $job = $this->getJobById($jobId);
        if (!$job) {
            return ['success' => false, 'message' => 'Job not found'];
        }

        if (empty($applicantData['full_name']) || empty($applicantData['email'])) {
            return ['success' => false, 'message' => 'Name and email are required'];
        }

        if (!isValidEmail($applicantData['email'])) {
            return ['success' => false, 'message' => 'Invalid email format'];
        }

        $this->db->query('
            INSERT INTO job_applications (job_id, full_name, email, phone, resume_path, 
                                         cover_letter, status, applied_at)
            VALUES (:job_id, :full_name, :email, :phone, :resume_path, 
                   :cover_letter, :status, NOW())
        ');
        
        $this->db->bind(':job_id', $jobId);
        $this->db->bind(':full_name', $applicantData['full_name']);
        $this->db->bind(':email', $applicantData['email']);
        $this->db->bind(':phone', $applicantData['phone'] ?? '');
        $this->db->bind(':resume_path', $applicantData['resume_path'] ?? '');
        $this->db->bind(':cover_letter', $applicantData['cover_letter'] ?? '');
        $this->db->bind(':status', 'pending');

        return $this->db->execute() ? 
            ['success' => true, 'message' => 'Application submitted successfully'] :
            ['success' => false, 'message' => 'Failed to submit application'];
    }

    /**
     * Get job applications
     */
    public function getJobApplications($jobId = null, $limit = null, $offset = 0) {
        $sql = '
            SELECT ja.id, ja.job_id, ja.full_name, ja.email, ja.phone, 
                   ja.resume_path, ja.status, ja.applied_at, j.title as job_title
            FROM job_applications ja
            JOIN jobs j ON ja.job_id = j.id
        ';
        
        if ($jobId) {
            $sql .= ' WHERE ja.job_id = :job_id';
        }
        
        $sql .= ' ORDER BY ja.applied_at DESC';
        
        if ($limit) {
            $sql .= ' LIMIT :limit OFFSET :offset';
        }
        
        $this->db->query($sql);
        
        if ($jobId) {
            $this->db->bind(':job_id', $jobId);
        }
        
        if ($limit) {
            $this->db->bind(':limit', $limit, PDO::PARAM_INT);
            $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        }
        
        return $this->db->resultSet();
    }

    /**
     * Update application status
     */
    public function updateApplicationStatus($applicationId, $status) {
        $validStatuses = ['pending', 'reviewed', 'shortlisted', 'rejected', 'accepted'];
        
        if (!in_array($status, $validStatuses)) {
            return ['success' => false, 'message' => 'Invalid status'];
        }

        $this->db->query('UPDATE job_applications SET status = :status WHERE id = :id');
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $applicationId);

        return $this->db->execute() ? 
            ['success' => true, 'message' => 'Application status updated successfully'] :
            ['success' => false, 'message' => 'Failed to update application status'];
    }

    /**
     * Get total jobs
     */
    public function getTotalJobs() {
        $this->db->query('SELECT COUNT(*) as count FROM jobs WHERE status = "active"');
        $result = $this->db->single();
        return $result['count'];
    }

    /**
     * Get total applications
     */
    public function getTotalApplications() {
        $this->db->query('SELECT COUNT(*) as count FROM job_applications');
        $result = $this->db->single();
        return $result['count'];
    }
}
