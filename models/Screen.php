<?php
// /models/Screen.php

class Screen
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Fetch all screens
     */
    public function getAllScreens()
    {
        $stmt = $this->pdo->query("SELECT * FROM signage_screens ORDER BY screen_group, screen_number ASC");
        return $stmt->fetchAll();
    }

    /**
     * Fetch screens by group
     */
    public function getScreensByGroup($group)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM signage_screens WHERE screen_group = ? ORDER BY screen_number ASC");
        $stmt->execute([$group]);
        return $stmt->fetchAll();
    }

    /**
     * Fetch one screen by ID
     */
    public function getScreenById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM signage_screens WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Create a new screen
     */
    public function createScreen($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO signage_screens 
            (screen_number, screen_name, screen_group, ticker_text, qr_link, theme, ticker_speed, ticker_direction, ticker_font_size, ticker_color, ticker_bg_color, ticker_enabled, ticker_font, rotation_interval, layout_mode)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['screen_number'],
            $data['screen_name'],
            $data['screen_group'],
            $data['ticker_text'],
            $data['qr_link'],
            $data['theme'],
            $data['ticker_speed'],
            $data['ticker_direction'],
            $data['ticker_font_size'],
            $data['ticker_color'],
            $data['ticker_bg_color'],
            $data['ticker_enabled'],
            $data['ticker_font'],
            $data['rotation_interval'],
            $data['layout_mode']
        ]);
    }

    /**
     * Update an existing screen
     */
    public function updateScreen($id, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE signage_screens SET
                screen_number = ?, 
                screen_name = ?, 
                screen_group = ?, 
                ticker_text = ?, 
                qr_link = ?, 
                theme = ?, 
                ticker_speed = ?, 
                ticker_direction = ?, 
                ticker_font_size = ?, 
                ticker_color = ?, 
                ticker_bg_color = ?, 
                ticker_enabled = ?, 
                ticker_font = ?, 
                rotation_interval = ?, 
                layout_mode = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $data['screen_number'],
            $data['screen_name'],
            $data['screen_group'],
            $data['ticker_text'],
            $data['qr_link'],
            $data['theme'],
            $data['ticker_speed'],
            $data['ticker_direction'],
            $data['ticker_font_size'],
            $data['ticker_color'],
            $data['ticker_bg_color'],
            $data['ticker_enabled'],
            $data['ticker_font'],
            $data['rotation_interval'],
            $data['layout_mode'],
            $id
        ]);
    }

    /**
     * Delete a screen
     */
    public function deleteScreen($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM signage_screens WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>
