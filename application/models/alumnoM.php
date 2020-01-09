<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class alumnoM extends CI_Model {
	
	public function get_alumno()
	{	
		$this->db->select('a.id_alumno, a.nombres, a.apellidos, s.nombre_sexo, c.nombre_curso');
		$this->db->from('alumno a');
		$this->db->join('sexo s', 's.id_sexo=a.id_sexo');
		$this->db->join('curso c','c.id_curso=a.id_curso');
		$exe=$this->db->get();
		return $exe->result();
	}

	public function eliminar($id)
	{
		$this->db->where('id_alumno',$id);
		$this->db->delete('alumno');

		if ($this->db->affected_rows() > 0 ) {
			return true;
		}else{
			return false;
		}
	}

	public function get_sexo()
	{	
		$exe=$this->db->get('sexo');
		return $exe->result();
	}

	public function get_curso()
	{	
		$exe=$this->db->get('curso');
		return $exe->result();
	}

	public function set_alumno($datos)
	{
		$this->db->set('nombres',$datos['nombre']);
		$this->db->set('apellidos',$datos['apellido']);
		$this->db->set('id_sexo',$datos['sexo']);
		$this->db->set('id_curso',$datos['curso']);
		
		$this->db->insert('alumno');
		if ($this->db->affected_rows()>0) {
			return "add";
		}
	}

	public function get_datos($id)
	{
		$this->db->where('id_alumno',$id);
		$exe= $this->db->get('alumno');

		if ($this->db->affected_rows()>0) {
			return $exe->row();
		}else{
			return false;
		}
	}

	public function actualizar($datos){
		$this->db->set('nombres',$datos['nombre']);
		$this->db->set('apellidos',$datos['apellido']);
		$this->db->set('id_sexo',$datos['sexo']);
		$this->db->set('id_curso',$datos['curso']);
		$this->db->where('id_alumno',$datos['id_alumno']);
		
		$this->db->update('alumno');
		if ($this->db->affected_rows()>0) {
			return 'edi';
		}
	}
}
