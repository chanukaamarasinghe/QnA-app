<?php
class Posts extends CI_Controller
{
	public function index()
	{

		$data['title'] = 'Latest Posts';

		$data['posts'] = $this->post_model->get_posts(FALSE);
		$this->load->view('templates/header');
		$this->load->view('posts/index', $data);
		$this->load->view('templates/footer');
	}

	public function view($id = NULL)
	{
		$data['post'] = $this->post_model->get_posts($id);
		$post_id = $data['post']['id'];
		$data['comments'] = $this->comment_model->get_comments($post_id);

		if (empty($data['post'])) {
			show_404();
		}

		$data['title'] = $data['post']['title'];

		$this->load->view('templates/header');
		$this->load->view('posts/view', $data);
		$this->load->view('templates/footer');
	}

	public function create()
	{
		// Check login
		if(!$this->session->userdata('logged_in')){
			redirect('users/login');
		}

		$data['title'] = 'Create Post';
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('body', 'Descriptionody', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
			$this->load->view('posts/create', $data);
			$this->load->view('templates/footer');
		} else {
			//$this->post_model->create_post($post_image);
			$this->post_model->create_post();
			// Set message
			$this->session->set_flashdata('post_created', 'Your post has been created');
			redirect('posts');
		}
	}
	public function delete($id)
	{
		// Check login
		if(!$this->session->userdata('logged_in')){
			redirect('users/login');
		}

		$this->post_model->delete_post($id);

		// Set message
		$this->session->set_flashdata('post_deleted', 'Your post has been deleted');

		redirect('posts');
	}
	public function edit($id)
	{
		// Check login
		if(!$this->session->userdata('logged_in')){
			redirect('users/login');
		}
		$data['post'] = $this->post_model->get_posts($id);

		// Check user
		if($this->session->userdata('user_id') != $this->post_model->get_posts($id)['user_id']){
			redirect('posts');
		}

		if (empty($data['post'])) {
			show_404();
		}

		$data['title'] = 'Edit Post';

		$this->load->view('templates/header');
		$this->load->view('posts/edit', $data);
		$this->load->view('templates/footer');
	}

	public function update()
	{
		// Check login
		// if(!$this->session->userdata('logged_in')){
		// 	redirect('users/login');
		// }

		$this->post_model->update_post();

		// Set message
		$this->session->set_flashdata('post_updated', 'Your post has been updated');

		redirect('posts');
	}
}
