/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.sms;

import org.smslib.AGateway;
import org.smslib.IOrphanedMessageNotification;
import org.smslib.InboundMessage;

/**
 *
 * @author ASUS
 */
public class OrphanedNotification implements IOrphanedMessageNotification{

    @Override
    public boolean process(AGateway gateway, InboundMessage msg) {
        System.out.println(">>>Pesan Orphaned diterima dari gateway: " + gateway.getGatewayId());
        System.out.println(msg);
        // Masih dalam tahap test (keterangan dari SMSLIB)
        System.out.println("PESAN:");
        return false;
    }
}
