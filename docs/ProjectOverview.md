# Project Overview

## 1. System Objectives
The main objective of the Inventory Asset Tracking System for Mindoro State University Main Campus is to provide the Supply and Property Services Office with a centralized, automated platform to accurately track, monitor, and manage all physical assets—including equipment, furniture, electronics, vehicles, and supplies—throughout their lifecycle, ensuring enhanced asset accountability, maintenance efficiency, and compliance with institutional policies. This objective aligns directly with the scope of covering all physical assets managed by the university’s Supply and Property Services Office, enabling them to maintain real-time visibility and control over inventory, reduce losses, facilitate timely maintenance, and support audit and reporting requirements effectively.

## 2. Proposed Scope
The system will cover all physical assets owned or managed by Mindoro State University - Main Campus, including equipment, furniture, electronics, vehicles, and supplies.

## 3. Stakeholders
Our stakeholder will be the Supply and Property Services Office because they are responsible for tracking, maintenance, and custody of inventories and other university assets—this is likely the system's primary user.

## 4. Tools & Technologies
**Languages/Frameworks:** PHP/Laravel  
**Integration approach:** User Authentication, Role-Based Access Control, Asset Registration, Maintenance Scheduling, Reporting  
**Repos/Services:** GitHub  
**Testing tools:** Google Chrome Mobile Simulator (for responsive testing)

# High-Level System Overview
The Inventory Asset Tracking System for Mindoro State University Main Campus is a centralized, automated platform designed to manage physical assets—such as equipment, furniture, electronics, vehicles, and supplies—throughout their lifecycle. Its main purpose is to provide real-time visibility, accurate tracking, and efficient control of inventory, ensuring that assets are properly assigned, maintained, and audited.  

Target users include the Supply and Property Services Office, university administrators, department heads, and IT personnel. The system offers significant benefits such as enhanced accountability, reduced asset loss, streamlined maintenance scheduling, and improved compliance with institutional and regulatory standards. With robust security, scalability, and usability features, it supports high performance under load, ensures data integrity, and enables seamless integration with other university systems—ultimately driving operational efficiency and long-term cost savings.

# Integration Pattern
Hub-spoke

# Rationale
In the Inventory Asset Tracking System, the Hub-Spoke integration pattern manages all communication between modules through a central hub. When a new asset is registered, the Asset Registration Module sends details to the Hub, which updates the Asset Tracking Module for monitoring. If maintenance is required, the Tracking Module notifies the Hub, which forwards the request to the Maintenance Module. The Reporting Module retrieves updated asset and maintenance data from the Hub to generate accurate reports.
When assets are scheduled for resale or disposal, the Hub makes them available to the Asset Bidding Module, where users can place bids. Once the bidding process closes, the Hub forwards the results to the Asset Auction Module, which finalizes auctions and updates the system with winning bids and transaction details. Finally, the Reporting Module consolidates auction and bidding outcomes to provide administrators with complete oversight of asset lifecycle activities. This ensures a streamlined, centralized, and accountable asset management process.