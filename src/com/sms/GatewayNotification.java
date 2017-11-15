/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.sms;

import org.smslib.AGateway;
import org.smslib.IGatewayStatusNotification;

/**
 *
 * @author ASUS
 */
public class GatewayNotification implements IGatewayStatusNotification {

    SmsService service = null;
    
    public GatewayNotification(SmsService service){
        this.service = service;
    }
    
    @Override
    public void process(AGateway gateway, AGateway.GatewayStatuses oldStatus, AGateway.GatewayStatuses newStatus) {
        this.service.setStatus(newStatus);
        System.out.println("Gateway status " + gateway.getGatewayId() + ", from: " + oldStatus + " to: " + newStatus);
    }
}
