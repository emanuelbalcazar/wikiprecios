<?php

/**
* Clase que representa un Precio de producto.
*
* @package         CodeIgniter
* @subpackage      Models
* @category        Models
*/
class Price extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->table = 'prices';
    }

    /**
     * Registra o actualiza un nuevo precio calculado
     *
     * @access  public
     * @param $commerce comercio donde esta el producto
     * @param $product_code codigo del producto
     * @param $price precio que se mostrara al usuario
     * @param $price_1
     * @param $price_2
     */
    public function register_new_price_calculated($commerce, $product_code, $price_1 = 0, $price_2 = 0, $price = 0)
    {
        $data = array(
            'product_code' => $product_code,
            'commerce_id' => $commerce,
            'price' => $price,
            'price_1' => $price_1,
            'price_2' => $price_2,
            'date' => date("Y-m-d")
        );

        $this->db->select('count(*) as count');
        $this->db->from('pricescalculated');
        $this->db->where('product_code', $product_code);
        $this->db->where('commerce_id', $commerce);
        $ok = $this->db->get();

        if ($ok->row()->count > 0) {
            $this->db->where('product_code', $product_code);
            $this->db->where('commerce_id', $commerce);

            $result = $this->db->update('pricescalculated', $data);
        } else {
            $result = $this->db->insert('pricescalculated', $data);
        }
        return $result;
    }

    /**
     * Retorna los ultimos precios de un producto en el lapso de 5 dias
     *
     * @access  public
     * @param $commerce comercio donde esta el producto
     * @param $product_code codigo del producto
     * @param $days cantidad de dias limite
     */
    public function get_last_prices($commmerce, $product_code, $days) {
        $where = "p.date between current_date() -".$days." and current_date()";

        // La calificacion maxima es 5, se le resta a un numero arbitrario la diferencia
        // de dias entre la fecha actual y la registrada por el precio sumandole luego
        // la calificacion del usuario para tomarlo como referencia de ranking.
        $this->db->select('p.price, (5 - datediff(now(), p.date) + u.qualification) ranking');
        $this->db->from('prices p');
        $this->db->join('users as u', 'p.user = u.mail', 'left');
        $this->db->where('product_code', $product_code);
        $this->db->where('commerce_id', $commmerce);
        $this->db->where($where);
        $this->db->order_by('ranking', 'desc');
        $result = $this->db->get();

        return $result->result();
    }

    /**
     * Retorna los precios calculados de un producto en un comercio
     *
     * @access  public
     * @param $product_code codigo del producto
     * @param $commerce comercio donde esta el producto
     */
    public function get_product_prices($product_code, $commerce)
    {
        $this->db->where('product_code', $product_code);
        $this->db->where('commerce_id', $commerce);
        $result = $this->db->get('pricescalculated');

        return $result->row();
    }

    public function exists_calculated_price($product_code, $commerce)
    {
        $this->db->select('count(*) as count');
        $this->db->from('pricescalculated');
        $this->db->where('product_code', $product_code);
        $this->db->where_not_in('commerce_id', $commerce);
        $result = $this->db->get();

        return ($result->row()->count > 0);

    }

    /**
     * Retorna los precios de un producto que esten en los comercios favoritos del usuario
     *
     * @access  public
     * @param $product_code codigo de barra del producto
     * @param $user usuario que solicita los precios
     * @param $commerce comercio donde esta el usuario para evitar traer los precios del mismo comercio
     *       donde se realiza la peticion.
     */
    public function get_favorites_prices($product_code, $user, $commerce)
    {
        $ids = array();
        $favorites = $this->_get_all_favorites_businesses($user);

        if (count($favorites) == 0) {
            return $favorites;
        }

        $latitude = $this->_get_latitude($commerce);
        $longitude = $this->_get_longitude($commerce);

        foreach ($favorites as $key => $id) {
            $ids[] = $id['commerce_id'];
        }

        $this->db->select('e.id, e.name, p.price, p.product_code, p.date, p.price_1, p.price_2');
        $this->db->from('pricescalculated p');
        $this->db->join('businesses as e', 'e.id = p.commerce_id', 'left');
        $this->db->where('p.product_code', $product_code);
        $this->db->where_not_in('e.id', $commerce);
        $this->db->where_in('p.commerce_id', $ids);
        $result = $this->db->get();

        return $result->result();
    }

    /**
     * Retorna los precios de un producto que NO esten en los comercios favoritos del usuario
     *
     * @access  public
     * @param $idProduct codigo de barra del producto
     * @param $user usuario que solicita los precios
     * @param $idCommerce comercio donde esta el usuario para evitar traer los precios del mismo comercio
     *       donde esta el usuario.
     */
    public function get_prices_that_are_not_favorites($product_code, $user, $commerce)
    {
        $ids = array();
        $favorites = $this->_get_all_favorites_businesses($user);
        $latitude = $this->_get_latitude($commerce);
        $longitude = $this->_get_longitude($commerce);

        foreach ($favorites as $id) {
            $ids[] = $id['commerce_id'];
        }

        if (count($ids) == 0) {
            $ids = -1;
        }

        $this->db->select('e.id, e.name, p.price, p.product_code, p.date, p.price_1, p.price_2');
        $this->db->from('pricescalculated p');
        $this->db->join('businesses as e', 'e.id = p.commerce_id', 'left');
        $this->db->where('p.product_code', $product_code);
        $this->db->where_not_in('e.id', $commerce);
        $this->db->where_not_in('p.commerce_id', $ids);
        $result = $this->db->get();
        return $result->result();
    }

    /**
     * Retorna todos los comercios favoritos de un usuario
     *
     * @access  private
     * @param usuario
     */
    private function _get_all_favorites_businesses($user)
    {
        $this->db->select('commerce_id');
        $this->db->from('favorites');
        $this->db->where('user', $user);
        $result = $this->db->get();
        return $result->result_array();
    }

    /**
     * Retorna la latitud de la ubicacion de un comercio
     *
     * @access  private
     * @param commerce
     */
    private function _get_latitude($commerce)
    {
        $this->db->select('latitude');
        $this->db->from('businesses');
        $this->db->where('id', $commerce);
        $result = $this->db->get();

        return $result->row()->latitude;
    }

    /**
     * Retorna la longitud de la ubicacion de un comercio
     *
     * @access  private
     * @param commerce
     */
    private function _get_longitude($commerce)
    {
        $this->db->select('longitude');
        $this->db->from('businesses');
        $this->db->where('id', $commerce);
        $result = $this->db->get();

        return $result->row()->longitude;
    }

    /**
     * Retorna los posibles precios de un producto en un comercio determinado
     * para que el usuario tenga un listado de sugerencias
     *
     * @access  public
     * @param $commerce comercio donde esta el producto
     * @param $idProduct
     */
    public function get_possible_prices($commerce, $product_code)
    {
        $this->db->select('price');
        $this->db->distinct(TRUE);
        $this->db->where('product_code', $product_code);
        $this->db->where('commerce_id', $commerce);
        $this->db->order_by('id', 'desc');
        $this->db->limit(5);
        $result = $this->db->get('prices');

        return $result->result();
    }

}
