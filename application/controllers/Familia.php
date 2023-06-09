<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 12/09/2018
 * Time: 16:28
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Familia extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Familia';

        $this->load->model('model_familia');
    }

    /*
    * It only redirects to the manage product page and
    */
    public function index()
    {
        if (!in_array('viewBrand', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = $this->model_familia->getFamiliaData();

        $this->data['results'] = $result;

        $this->render_template('articulos/index', $this->data);
    }

    public function getFamiliaData()
    {
        $result = array('data' => array());

        $data = $this->model_familia->getFamiliaData();
        foreach ($data as $key => $value) {

            // button
            $buttons = '';

            if (in_array('viewBrand', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default" onclick="editFamilia(' . $value['ID'] . ')" data-toggle="modal" data-target="#editFamiliaModal"><i class="fa fa-pencil"></i></button>';
            }

            if (in_array('deleteBrand', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFamilia(' . $value['ID'] . ')" data-toggle="modal" data-target="#removeFamiliaModal"><i class="fa fa-trash"></i></button>';
            }

//            $status = ($value['Activo'] == 1) ? '<span class="label label-success">Activo</span>' : '<span class="label label-warning">Inactivo</span>';

            $result['rows'][$key] = array(
                'ID' => $value['ID'],
                'Nombre' => $value['Nombre'],
                'Descripcion' => $value['Descripcion'],
                'Buttons' => $buttons

            );
        } // /foreach

        echo json_encode($result);
    }


    public function getFamiliaDataById($id)
    {
        if ($id) {
            $data = $this->model_familia->getFamiliaData($id);
            echo json_encode($data);
        }

        return false;
    }

    /*
    * Its checks the brand form validation
    * and if the validation is successfully then it inserts the data into the database
    * and returns the json format operation messages
    */
    public function create()
    {

        if (!in_array('createBrand', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

            $response = array();

        $this->form_validation->set_rules('familia_nombre', 'Nombre artículo', 'trim|required');
        $this->form_validation->set_rules('familia_descripcion', 'Descripción', 'trim');
        $this->form_validation->set_rules('familia_unidades', 'Unidades', 'trim|required');


        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'Nombre' => $this->input->post('familia_nombre'),
                'Descripcion' => $this->input->post('familia_descripcion'),
                'Unidades' => $this->input->post('familia_unidades'),

            );

            $create = $this->model_familia->create($data);
            if ($create == true) {
                $response['success'] = true;
                $response['messages'] = 'Familia creada';
            } else {
                $response['success'] = false;
                $response['messages'] = 'Error!';
            }
        } else {
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }

        echo json_encode($response);

    }

    /*
    * Its checks the brand form validation
    * and if the validation is successfully then it updates the data into the database
    * and returns the json format operation messages
    */
    public function update($id)
    {
        if (!in_array('updateBrand', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if ($id) {
            $this->form_validation->set_rules('edit_familia_nombre', 'Nombre familia', 'trim|required');
            $this->form_validation->set_rules('edit_familia_descripcion', 'Descripción', 'trim');
            $this->form_validation->set_rules('edit_familia_unidades', 'Unidades', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'Nombre' => $this->input->post('edit_familia_nombre'),
                    'Descripcion' => $this->input->post('edit_familia_descripcion'),
                    'Unidades' => $this->input->post('edit_familia_unidades'),

                );

                $update = $this->model_familia->update($data, $id);
                if ($update == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Familia actualizada';
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Error al actualizar';
                }
            } else {
                $response['success'] = false;
                foreach ($_POST as $key => $value) {
                    $response['messages'][$key] = form_error($key);
                }
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Recargue la página!!";
        }

        echo json_encode($response);
    }

    /*
    * It removes the brand information from the database
    * and returns the json format operation messages
    */
    public function remove()
    {
        if (!in_array('deleteBrand', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $familia_id = $this->input->post('familia_id');
        $response = array();
        if ($familia_id) {
            $delete = $this->model_familia->remove($familia_id);

            if ($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Familia eliminado";
            } else {
                $response['success'] = false;
                $response['messages'] = "Error al eliminar";
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Recargue la página!!";
        }

        echo json_encode($response);
    }

    /*************FAMILIA CON PAGINADO Y FILTRADO******************/
    ////PRUEBA CON PAGINADO Y FILTRADO
    public function fetchFamiliaDataFilteringPagination()
    {
        $result = array('data' => array());


        $search_field = $this->input->get('searchField'); // search field name
        $search_string = $this->input->get('searchString'); // search string
        $page = $this->input->get('page'); //page number
        $limit = $this->input->get('rows'); // number of rows fetch per page
        $sidx = $this->input->get('sidx'); // field name which you want to sort
        $sord = $this->input->get('sord'); // field data which you want to soft
        if(!$sidx) { $sidx = 1; } // if its empty set to 1
        $count = $this->model_familia->countTotal($search_field, $search_string);
        $total_pages = 0;
        if($count > 0) { $total_pages = ceil($count/$limit); }
        if($page > $total_pages) { $page = $total_pages; }
        $start = ($limit * $page) - $limit;

        $familiadata=($this->model_familia->fetchFamiliaDataFilteringPagination($sidx, $sord, $start, $limit, $search_field, $search_string));
//        $famdata = $this->model_familia->getFamiliaData();


        foreach ($familiadata as $key => $value) {
            $buttons = '';
            $nombreFamilia='';
//            echo $x['ID'];
            if($value->Unidades == 'm3')
                $value->Unidades = '<span class="label label-primary">Metros Cúbicos (m³)</span>';
            elseif ($value->Unidades == 'm2')
                $value->Unidades = '<span class="label label-success">Metros Cuadrados (m²)</span>';
            elseif ($value->Unidades == 'm')
                $value->Unidades = '<span class="label label-info">Unidades Lineales (m)</span>';
            else
                $value->Unidades = '<span class="label label-danger">Error</span>';

            if (in_array('deleteProduct', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFamilia(' . $value->ID . ')" data-toggle="modal" data-target="#removeFamiliaModal"><i class="fa fa-trash"></i></button>';
            }
            if (in_array('updateProduct', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default" onclick="editFamilia('.$value->ID.')" data-toggle="modal" data-target="#editFamiliaModal"><i class="fa fa-pencil"></i></button>';
            }
            $value->Buttons=$buttons;

//            $status = ($value->Activo == 1) ? '<span class="label label-success" >Activo</span>' : '<span class="label label-warning" >Inactivo</span>';
//            $value -> Activo =$status;

//                foreach($famdata as $famkey => $famvalue){
//                    if($famvalue['ID']==$value->Familia)
//                        $nombreFamilia = $famvalue['Nombre'];
//                }

//            $value->Familia = $nombreFamilia;
        }

        $data = array('page'=>$page,
            'total'=>$total_pages,
            'records'=>$count,
            'rows'=>$familiadata,
        );

        echo json_encode($data);
    }


}